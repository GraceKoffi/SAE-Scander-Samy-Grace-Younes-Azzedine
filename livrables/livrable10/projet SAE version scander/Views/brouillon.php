
                <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011-04-25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011-07-25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009-01-12</td>
                <td>$86,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012-03-29</td>
                <td>$433,060</td>
            </tr>
            <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                <td>2011-01-25</td>
                <td>$112,000</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>


<!-- Balise link pour DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.2.0/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.2.0/js/searchPanes.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>










<?php
                $totalPages = ceil($totalResultats / $perPage);
$range = 5;
$start = max($page - $range, 1);
$end = min($page + $range, $totalPages);
?>
<ul class="pagination" style="center">
    <?php
    // Génération des liens de pagination
    for ($i = $start; $i <= $end; $i++) :
    ?>
        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?controller=recherche&action=pagination&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
    <?php endfor; ?>

    <?php if ($end < $totalPages) : ?>
        <li class="page-item">
            <a class="page-link" href="#">...</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?controller=recherche&action=pagination&page=<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
        </li>
    <?php endif; ?>
</ul>




tt2039417 probleme affichage / aussi tt0194207
<img src="https://image.tmdb.org/t/p/w200<?= $portrait ?>" alt="<?= e($v['primarytitle']) ?>">
