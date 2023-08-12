<div class="container">
    <?php
    $daysInMonth = 31; 
    $firstDayOfMonth = 'Tue'; 
    // Map days of the week to their corresponding indices (0 for Mon, 6 for Sun)
    $dayIndexMap = ['Mon' => 0, 'Tue' => 1, 'Wed' => 2, 'Thu' => 3, 'Fri' => 4, 'Sat' => 5, 'Sun' => 6];
    
    // Get the index of the first day of the month
    $dayOfWeek = $dayIndexMap[$firstDayOfMonth];

    $matrix = [];

    $currentWeek = [];

    // Insert empty cells for the days before the first day of the month
    $currentWeek = array_pad($currentWeek, $dayOfWeek, '');

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $currentWeek[] = $day;

        if (count($currentWeek) == 7 || $day == $daysInMonth) {
            $matrix[] = $currentWeek;
            $currentWeek = [];
        }
    }
    ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Mon</th>
                <th scope="col">Tue</th>
                <th scope="col">Wed</th>
                <th scope="col">Thu</th>
                <th scope="col">Fri</th>
                <th scope="col">Sat</th>
                <th scope="col">Sun</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matrix as $week): ?>
                <tr>
                    <?php foreach ($week as $day): ?>
                        <td><?php echo $day; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
