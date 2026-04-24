<?php

return [
    'hours'   => array_combine(range(1, 12), range(1, 12)),
    'minutes' => array_combine(range(0, 55, 5), range(0, 55, 5)),
    'ampm'    => array_combine(['AM', 'PM'], ['AM', 'PM']),
];
