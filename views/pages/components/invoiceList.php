
<a class="toright" href="<?php echo STARTING_URL ?>">
    <button class="button secondary small">Wróć</button>
</a>
<div class="box">
    <h1> Lista Faktur</h1>
    <form action="" method="GET">
        <div class="search-bar">
            <label>
                Wyszukaj po:
                <select class="form-input" name="searchSelect" onchange="changeSelector()">
                    <option value="id">Identyfikatorze własnym</option>
                    <option value="invoice_number">Numerze faktury</option>
                    <option value="vat_id">VAT ID kontrahenta</option>
                    <option value="name">Nazwie kontrahenta</option>
                </select>
            </label>
            <label>
                Wyszukaj:
                <input type="text" class="form-input" name="search" value="<?php echo $_GET['search'] ?? ''?>"/>
            </label>
            <div>
                Przedział czasowy:
                <div class="flex">
                    <input class="form-input" type="date" name="since_date" value="<?php echo $_GET['since_date'] ?>"/>
                    <input class="form-input" type="date" name="to_date" value="<?php echo $_GET['to_date'] ?>"/>
                </div>
            </div>

            <div>
                <label>
                    Rodzaj faktury:
                    <select class="form-input" name="invoice_type" >
                        <option value="all">Wszystkie</option>
                        <option value="buy">Kupna</option>
                        <option value="sale">Sprzedaży</option>
                    </select>
                </label>
            </div>
            <input class="button primary small span-2-end" type="submit" value="Szukaj.." name="Result">
        </div>
    </form>

    <br>
    <div class="table-container">
    <table class="form-table spacing">
        <thead>
        <tr>
            <th>Numer faktury</th>
            <th>Kontrahent</th>
            <th>NIP</th>
            <th>Data wystawienia faktury</th>
            <th>Typ</th>
            <th>Cena Brutto</th>
            <th>Szczegóły</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //dump($results);
        foreach ($results['elements'] as $row) {
            echo '<tr>';
            echo '<td>' . $row->invoice_number . '</td>';
            echo '<td>' . $row->name . '</td>';
            echo '<td>' . $row->vat_id . '</td>';
            echo '<td>' . $row->date_of_invoice . '</td>';
            echo '<td>' . $row->type . '</td>';
            echo '<td>' . $row->sum_brutto . '</td>';
            echo '<td><a href="'. STARTING_URL . '/' . $_SESSION['user_role'] . '/show-invoice?invoiceId=' . $row->ID . '"' . '>
            <button class="button primary small">Więcej</button>
        </a></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    </div>
    <br>
    <div class="pagination-box">
        <h4>Paginacja</h4>
        <div class="pages">
            <?php
            if($_GET) {
                $search = $_GET['search'] ?? "";
                $searchSelect = $_GET['searchSelect'] ?? "";
                $since=$_GET['since_date'] ?? "";
                $to=$_GET['to_date'] ?? "";
                $invoiceType=$_GET['invoice_type'] ?? "";
            }


            for ($i = 1; $i <= $results['paginationInfo']; $i++) {
                $page = 1;
                $class = "";
                if (isset($_GET['page'])){
                    if ((int)$_GET['page']==$i){
                        $class = "class='bold'";
                    }
                } else{
                    if ($i == 1){
                        $class = "class='bold'";
                    }
                }
                echo " <a " . $class . "href='?page=" . $i . "&searchSelect=".$searchSelect. "&search=".$search."&since_date=".$since."&to_date=".$to."&invoice_type=".$invoiceType."'>" . $i . "</a>";
            }
            ?>
        </div>
    </div>

</div>




<script>
    const OPTIONS = [
        "Identyfikator własny",
        "Numer faktury",
        "Vat ID kontrahenta",
        "Nazwa kontrahenta",
    ]

    const searchOptions = {
        "id": 0,
        "invoice_number": 1,
        "vat_id": 2,
        "name": 3,
    }

    const radioOptions = {
        "First": 0,
        "Second": 1,
    }

    const typesOptions = {
        "all": 0,
        "buy": 1,
        "sale": 2,
    }


    const selector = document.querySelector('select[name="searchSelect"]');
    const typeSelector = document.querySelector('select[name="invoice_type"]');


    const url_str = window.location;
    const url = new URL(url_str);

    const searchBy = url.searchParams.get("searchSelect");
    const searchType = url.searchParams.get("invoice_type");

    if (searchType){
        typeSelector.selectedIndex = typesOptions[`${searchType}`];
    }

    if (searchBy){
        selector.selectedIndex = searchOptions[searchBy];
    }


    function changeSelector(){
        const search = document.querySelector('input[name="search"]');
        search.placeholder = OPTIONS[selector.selectedIndex];
    }

    changeSelector();
</script>