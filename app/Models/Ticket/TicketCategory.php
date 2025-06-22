<?php

namespace App\Models\Ticket;

/**
 *
 */
enum TicketCategory: string
{
    case TECHNICAL_SUPPORT = 'technical_support';
    case BILLING_PAYMENT = 'billing_payment';
    case ACCOUNT_ACCESS = 'account_access';
    case BUG_REPORT = 'bug_report';
    case FEATURE_REQUEST = 'feature_request';
    case GENERAL_INQUIRY = 'general_inquiry';
    case REFUND_REQUEST = 'refund_request';
    case INSTALLATION_HELP = 'installation_help';
    case PERFORMANCE_ISSUE = 'performance_issue';
    case SECURITY_CONCERN = 'security_concern';
    case DATA_EXPORT = 'data_export';
    case INTEGRATION_SUPPORT = 'integration_support';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::TECHNICAL_SUPPORT => 'Technical Support',
            self::BILLING_PAYMENT => 'Billing & Payment',
            self::ACCOUNT_ACCESS => 'Account Access',
            self::BUG_REPORT => 'Bug Report',
            self::FEATURE_REQUEST => 'Feature Request',
            self::GENERAL_INQUIRY => 'General Inquiry',
            self::REFUND_REQUEST => 'Refund Request',
            self::INSTALLATION_HELP => 'Installation Help',
            self::PERFORMANCE_ISSUE => 'Performance Issue',
            self::SECURITY_CONCERN => 'Security Concern',
            self::DATA_EXPORT => 'Data Export',
            self::INTEGRATION_SUPPORT => 'Integration Support',
        };
    }

    /**
     * @return TicketCategory[]
     */
    public static function getCategoryKeysList(): array
    {
        return [
            self::TECHNICAL_SUPPORT->value,
            self::BILLING_PAYMENT->value,
            self::ACCOUNT_ACCESS->value,
            self::BUG_REPORT->value,
            self::FEATURE_REQUEST->value,
            self::GENERAL_INQUIRY->value,
            self::REFUND_REQUEST->value,
            self::INSTALLATION_HELP->value,
            self::PERFORMANCE_ISSUE->value,
            self::SECURITY_CONCERN->value,
            self::DATA_EXPORT->value,
            self::INTEGRATION_SUPPORT->value
        ];
    }

    /**
     * @param string $categoryValue
     * @return self
     */
    public static function getCategoryEnum(string $categoryValue): self
    {
        return match($categoryValue) {
            'technical_support' => self::TECHNICAL_SUPPORT,
            'billing_payment' => self::BILLING_PAYMENT,
            'account_access' => self::ACCOUNT_ACCESS,
            'bug_report' => self::BUG_REPORT,
            'feature_request' => self::FEATURE_REQUEST,
            'general_inquiry' => self::GENERAL_INQUIRY,
            'refund_request' => self::REFUND_REQUEST,
            'installation_help' => self::INSTALLATION_HELP,
            'performance_issue' => self::PERFORMANCE_ISSUE,
            'security_concern' => self::SECURITY_CONCERN,
            'data_export' => self::DATA_EXPORT,
            'integration_support' => self::INTEGRATION_SUPPORT
        };
    }

    /**
     * @return mixed
     */
    public static function getCategoriesForSystemPrompt(){
        return `
- **technical_support** - General technical assistance, troubleshooting, how-to questions
- **billing_payment** - Payment issues, billing inquiries, subscription problems
- **account_access** - Login issues, password resets, account lockouts, permissions
- **bug_report** - Software bugs, system errors, unexpected behavior
- **feature_request** - New feature suggestions, enhancement requests, improvements
- **general_inquiry** - General questions, information requests, clarifications
- **refund_request** - Refund requests, cancellation requests, return policies
- **installation_help** - Installation assistance, setup guidance, configuration help
- **performance_issue** - Slow performance, system lag, optimization problems
- **security_concern** - Security issues, data protection, unauthorized access, breaches
- **data_export** - Data export requests, data migration, backup assistance
- **integration_support** - API issues, third-party integrations, connectivity problems`;
    }
}
