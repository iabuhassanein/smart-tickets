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

## Categories (USE EXACTLY THESE NAMES):".$catPrompt."

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
                - Ticket Subject: ".$ticket->getSubject()."
                - Ticket Content: ".$ticket->getBody()."
                "],
                ],
            ]);

            $res =  $result->choices[0]->message->content;
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
}
