<?php

namespace App\Services;

use App\Domain\AITicketClassifier\TicketClassifierInterface;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use Exception;
use OpenAI\Laravel\Facades\OpenAI;

class TicketClassifier implements TicketClassifierInterface
{
    public function classifyTicket(Ticket $ticket): array
    {
        // when OPENAI_CLASSIFY_ENABLED=false, return a random category and dummy explanation/confidence.
        if (!config('openai.classify_enabled'))
            return $this->dummyClassify();

        try {
            $catPrompt = TicketCategory::getCategoriesForSystemPrompt();
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => "system", 'content' => "You are a support ticket classifier. Analyze the provided support ticket and classify it into the most appropriate category.

## Categories (USE EXACTLY THESE NAMES):" . $catPrompt . "

## CRITICAL REQUIREMENT:
You MUST use ONLY the exact category names listed above. Do NOT create variations or similar names.

## Instructions:
1. Read the ticket content carefully
2. Identify the primary issue or request
3. Match it to ONE of the 12 categories above using the EXACT name
4. Provide a brief explanation of your reasoning
5. Rate your confidence from 0.1 to 1.0

## Response Format:
Always respond with valid JSON containing exactly these 3 keys:

```json
{
  'category': 'technical_support',
  'explanation': 'Brief reason for this classification',
  'confidence': 0.85
}
```

## Examples:
- Billing issues → 'billing_payment' (NOT 'billing_issue')
- Login problems → 'account_access' (NOT 'login_issue')
- System crashes → 'bug_report' (NOT 'system_error')

## Guidelines:
- Choose the single most relevant category from the 12 options above
- Use ONLY the exact category names provided
- Keep explanations concise (1-2 sentences)
- Use high confidence (0.8+) only when certain
- Use lower confidence (0.5-0.7) for ambiguous cases
- Multiple issues should be classified by the primary concern

IMPORTANT: Your response must use one of these exact 12 category names: technical_support, billing_payment, account_access, bug_report, feature_request, general_inquiry, refund_request, installation_help, performance_issue, security_concern, data_export, integration_support"],


                    ['role' => 'user', 'content' => "
                - Ticket Subject: " . $ticket->getSubject() . "
                - Ticket Content: " . $ticket->getBody() . "
                "],
                ],
            ]);

            $res = $result->choices[0]->message->content;
            $arrayResult = $this->parseResponse($res);
            return ['success' => true, ...$arrayResult];
        } catch (Exception $e) {
            return [
                'success' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @throws Exception
     */
    function parseResponse($response): array
    {
        // Remove triple backticks and json markers
        $cleaned = preg_replace('/```json\s*/', '', $response);
        $cleaned = preg_replace('/```\s*/', '', $cleaned);
        $cleaned = trim($cleaned);

        // Replace single quotes with double quotes for valid JSON
        $cleaned = preg_replace("/'/", '"', $cleaned);

        // Parse JSON to array
        $array = json_decode($cleaned, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON: ' . json_last_error_msg());
        }

        return $array;
    }

    function dummyClassify(): array
    {
        $categories = TicketCategory::getCategoryKeysList();
        $randomCategory = $categories[array_rand($categories)];
        return [
            'success' => true,
            'category' => $randomCategory,
            'explanation' => 'This is a dummy classification generated for testing purposes.',
            'confidence' => rand(50, 100) / 100,
        ];
    }

    public function explainCategoryChoice(Ticket $ticket, string $manualCategory): array
    {
        // when OPENAI_CLASSIFY_ENABLED=false, return dummy explanation
        if (!config('openai.classify_enabled'))
            return $this->dummyExplain($manualCategory);
        try {
            $catPrompt = TicketCategory::getCategoriesForSystemPrompt();
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => "system", 'content' => "You are a support ticket analysis expert. A human has manually categorized a support ticket, and you need to analyze whether this categorization makes sense and explain the reasoning.

## Available Categories:" . $catPrompt . "

## Your Task:
Analyze the provided ticket content and the human-assigned category. Then:
1. Evaluate if the assigned category fits the ticket content
2. Provide a detailed explanation of why this category choice makes sense (or doesn't)
3. Rate your confidence in this categorization from 0.1 to 1.0

## Response Format:
Always respond with valid JSON containing exactly these 3 keys:
```json
{
  'category': 'technical_support',
  'explanation': 'Brief reason for this classification',
  'confidence': 0.85
}
```

## Guidelines:
- Focus on explaining the reasoning behind the assigned category
- If the category seems appropriate, explain what aspects of the ticket support this choice
- If the category seems questionable, explain what might be concerning while being respectful
- Use high confidence (0.8+) when the category clearly fits
- Use medium confidence (0.5-0.7) when the category is reasonable but not perfect
- Use low confidence (0.1-0.4) when the category seems mismatched
- Keep explanations informative and constructive"],

                    ['role' => 'user', 'content' => "
                Please analyze this ticket and the manually assigned category:

                - Ticket Subject: " . $ticket->getSubject() . "
                - Ticket Content: " . $ticket->getBody() . "
                - Manually Assigned Category: " . $manualCategory . "

                Explain why this category assignment makes sense and rate your confidence in it."],
                ],
            ]);

            $res = $result->choices[0]->message->content;
            $arrayResult = $this->parseResponse($res);
            return ['success' => true, ...$arrayResult];
        } catch (Exception $e) {
            return [
                'success' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    function dummyExplain($manualCategory): array
    {
        return [
            'success' => true,
            'category' => $manualCategory,
            'explanation' => 'This is a dummy classification generated for testing purposes.',
            'confidence' => rand(50, 100) / 100,
        ];
    }
}
