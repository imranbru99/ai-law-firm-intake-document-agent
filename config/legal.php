<?php

return [
    'firm_name' => env('LEGAL_FIRM_NAME', 'AI Law Firm Intake & Document Agent'),
    'accent' => '#1E3A8A',
    'practice_areas' => [
        'corporate' => 'Corporate / M&A',
        'litigation' => 'Litigation',
        'employment' => 'Employment',
        'ip' => 'Intellectual Property',
        'real_estate' => 'Real Estate',
        'immigration' => 'Immigration',
        'family' => 'Family Law',
        'criminal' => 'Criminal Defense',
        'other' => 'Other',
    ],
    'matter_statuses' => [
        'intake' => 'Intake',
        'conflict_review' => 'Conflict Review',
        'open' => 'Open',
        'pending_docs' => 'Pending Documents',
        'esign' => 'E-Sign',
        'closed' => 'Closed',
        'declined' => 'Declined',
    ],
    'risk_levels' => [
        'clear' => 'Clear',
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'blocked' => 'Blocked',
    ],
];