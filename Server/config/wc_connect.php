<?php

return [
    'hours'   => array_combine(range(1, 12), range(1, 12)),
    'minutes' => array_combine(range(0, 55, 5), range(0, 55, 5)),
    'ampm'    => array_combine(['AM', 'PM'], ['AM', 'PM']),
    'status'  => array_combine([
        'upcoming',
        'live',
        'completed'
    ], [
        ['value' => 'Upcoming', 'class' => 'warning'],
        ['value' => 'Live Now', 'class' => 'danger'],
        ['value' => 'Completed', 'class' => 'success']
    ]),
    // only button or item
    'feature_items' => [
        [
            'colorClass' => 'blue',
            'icon' => 'fa-book-open',
            'heading' => 'Pre-read',
            'subHeading' => 'Read before the session',
            'type' => 'item',
            'pdf' => true,
            'video' => false,
        ],
        [
            'colorClass' => 'green',
            'icon' => 'fa-play',
            'heading' => 'Teaser',
            'subHeading' => 'Watch session teaser',
            'type' => 'item',
            'video' => true,
            'pdf' => false,
        ],
        [
            'colorClass' => null,
            'icon' => 'fa-calendar',
            'heading' => 'VIEW AGENDA',
            'subHeading' => null,
            'type' => 'button',
            'video' => false,
            'pdf' => true,
        ],
        [
            'colorClass' => 'orange',
            'icon' => 'fa-file-alt',
            'heading' => 'Summary',
            'subHeading' => 'View session summary',
            'type' => 'item',
            'video' => false,
            'pdf' => true,
        ],
    ],
    'cirtificate_complate_count' => [
        'Pre-read',
        'Teaser',
        'View Agenda',
        'Summary',
        'Assessment',
    ],
    'question_types' => [
        'mcq' => 'MCQ',
        'ranking' => 'Ranking',
        'descriptive' => 'Descriptive',
        'multi_optional' => 'Multi Optional',
        'mcq_other' => 'MCQ with "Any other" option',
        'multi_optional_other' => 'Multi Optional with "Any other" option',
    ],
];
