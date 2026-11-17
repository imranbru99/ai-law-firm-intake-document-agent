<?php

return [
    'conflict_check' => [
        'enabled' => env('MODULE_CONFLICT_CHECK', true),
        'label' => 'Conflict Check',
        'description' => 'Party matching, adverse party screening, and risk scoring before matter open.',
    ],
    'matter_intake' => [
        'enabled' => env('MODULE_MATTER_INTAKE', true),
        'label' => 'Matter Intake',
        'description' => 'Structured intake questionnaires, practice-area routing, and matter creation.',
    ],
    'document_ai' => [
        'enabled' => env('MODULE_DOCUMENT_AI', true),
        'label' => 'Document AI',
        'description' => 'Contract drafting assistance, clause extraction, and redline suggestions.',
    ],
    'esign_readiness' => [
        'enabled' => env('MODULE_ESIGN_READINESS', true),
        'label' => 'E-Sign Readiness',
        'description' => 'Signature packet assembly, signer sequencing, and completion tracking.',
    ],
    'client_portal' => [
        'enabled' => env('MODULE_CLIENT_PORTAL', true),
        'label' => 'Client Portal',
        'description' => 'Secure client uploads, status updates, and document exchange.',
    ],
    'billing_notes' => [
        'enabled' => env('MODULE_BILLING_NOTES', true),
        'label' => 'Billing Notes',
        'description' => 'Time/narrative capture linked to matters for billing teams.',
    ],
    'attendance_ops' => [
        'enabled' => env('MODULE_ATTENDANCE_OPS', false),
        'label' => 'Staff Attendance',
        'description' => 'Optional attendance hub integration for firm staff operations.',
    ],
];