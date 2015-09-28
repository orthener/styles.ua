<?php $this->set('title_for_layout', __d('cms', 'Import csv')); ?>
<h2><?php echo __d('cms', 'Import pliku csv'); ?></h2>
<?php
//echo empty($productsFromCsv) . "</br>";
//echo empty($productsDiff);
//exit;
?>

<?php if (empty($productsFromCsv) && empty($productsDiff)): ?>
    <h3><?php echo __d('cms', 'Jak zaimportować poprawnie produkty?'); ?></h3>
    <ul>
        <li>Do edycji pliku *.csv najlepiej użyć programu Calc z pakietu <a href="http://www.openoffice.org/">OpenOffice</a>, z opcjami:
            <ul>
                <li>kodowanie - Unicode (UTF-8)</li>
                <li>separator - średnik</li>
            </ul>
        </li>
        <li>Oznaczenia dodatkowe w pliku:
            <ul>
                <li><b>[require]</b> - oznacza że wartość w tej kolumnie jest wymagana</li>
                <li><b>[url]</b>
                    <ul>
                        <li>- oznacza pełną ścieżkę do zdjęcia z serwisu zewnętrznego <i>np: http://strona/podstrona/zdjecie.jpg</i><li/>
                        <li>- można dodać listę zdjęć oddzielając je znakiem "|" <i>np: http://strona/podstrona/zdjecie.jpg|http://strona/podstrona/zdjecie2.jpg</i></li>
                    </ul>
                </li>
                <li><b>(m - man, w - woman)</b> - oznacza dozwolone wartości w danej kolumnie</li>
                <li><b>{0.nn}</b> - format danych np: procent</li>
                <li><b>{*.nn}</b> - format danych np: wartość pieniężna</li>
            </ul>
        </li>
        <li>Opis kolumn:
            <ul>
                <li><b>id</b> - identyfikator produktu w systemie, jeśli zostanie  podany identyfikator który już istnieje w systemie to produkt zostanie nadpisany<br>
                    - jeśli zostanie podany identyfikator pusty lub taki który nie istnieje w systemie to produkt zostanie dodany jako produkt nowy</li>
                <li><b>title</b> - nazwa produktu <b>[require]</b></li>
                <li><b>barcode</b>- kod kreskowy</li>
                <li><b>product code</b> - kod produktu</li>
                <li><b>producer</b> - nazwa producenta</li>
                <li><b>brand</b> - nazwa marki, musi istnieć w systemie, jeśli nie istnieje, trzeba ją stworzyć lub wybrać z istniejących</li>
                <li><b>category</b> - kategoria produktu, musi istnieć w systemie, jeśli nie istnieje, trzeba ją stworzyć lub wybrać z istniejących</li>
                <li><b>gender</b> - dozwolone wartości: m, w</li>
                <li><b>size</b> - lista oznaczeń przedzielonych znakiem "|" np: 36|37|38|39</li>
                <li><b>weight</b> - masa w gramach</li>
                <li><b>quantity</b> - ilość dostępnych sztuk danego produktu. Jeśli produkt jest rozmiarowy to ilość podajemy tak jak rozmiary np: 12|30|67|52 <b>[require]</b></li>
                <li><b>realization time</b> - czas realizacji zamówienia podajemy w dniach</li>
                <li><b>price brutto</b> - cenę brutto wpisujemy w formacie dziesiętnym np: 12.55 <b>[require]</b></li>
                <li><b>tax</b> - w formacie dziesiętnym czyli 23% zapisujemy jako 0.23</li>
                <li><b>home page</b> - czy produkt ma być promowany na stronie głównej (1,0,""), pusta komórka traktowana jest jak 0</li>
                <li><b>sale</b> - czy produkt ma być na wyprzedaży (1,0,""), pusta komórka traktowana jest jak 0</li>
                <li><b>on blog</b> - czy produkt ma być widoczny na blogu (1,0,""), pusta komórka traktowana jest jak 0</li>
                <li><b>img</b> - zdjęcia produktu</li>
                <li><b>description</b> - opis produktu</li>
                <li><b>sized</b> - czy produkt ma jest rozmiarowy (1,0,""), pusta komórka traktowana jest jak 0</li>
            </ul>
        </li>
    </ul>
    <br/>
    <div class="windowsSizes form">
        <?php echo $this->Form->create('ProductCsv', array('type' => 'file')); ?>
        <fieldset>
            <legend><?php echo __d('cms', 'Wyślij plik (zgodny z formatem)'); ?></legend>
            <?php echo $this->Form->input('csv', array('type' => 'file')); ?>
        </fieldset>
        <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
    </div>
<?php else: ?>
    <h3><?php echo __d('public', 'Produkty do aktualizacji:'); ?></h3>
    <?php echo $this->Form->create('Product'); ?>

    <table class="update">
        <thead>
            <tr>
                <th><?php echo __d('cms', 'Id'); ?></th>
                <th><?php echo __d('cms', 'Title'); ?></th>
                <th>
                    <?php echo __d('cms', 'Kod kreskowy'); ?>
                    <span style="margin-left: 50%">&middot;</span><br/>
                    <?php echo __d('cms', 'Kod produktu'); ?>
                </th>
                <th><?php echo __d('cms', 'Producent'); ?></th>
                <th><?php echo __d('cms', 'Marka'); ?></th>
                <th><?php echo __d('cms', 'Kategoria'); ?></th>
                <th><?php echo __d('cms', 'Rozmiary produktu'); ?></th>
                <th><?php echo __d('cms', 'Produkt rozmiarowy'); ?></th>
                <th><?php echo __d('cms', 'Kolekcja damska/męska'); ?></th>
                <th><?php echo __d('cms', 'Waga [g]'); ?></th>
                <th><?php echo __d('cms', 'Ilość'); ?></th>
                <th><?php echo __d('cms', 'Czas realizacji<br/> zamówienia'); ?></th>
                <th><?php echo __d('cms', 'Cena'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th><?php echo __d('cms', 'Podatek'); ?></th>
                <th>
                    <?php echo __d('cms', 'Promowany na stronie głównej'); ?><br/>
                    <?php echo __d('cms', 'Wyprzedaż'); ?><br/>
                    <?php echo __d('cms', 'Promowany na blogu'); ?>
                </th>
                <!--<th><?php // echo __d('cms', 'Opis');  ?></th>-->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productsDiff AS $diff_key => $diff_value): ?>
                <tr class="altrow">
                    <td rowspan="2">
                        <?php echo $diff_key; ?><br>
                        <?php $opts = array('type' => 'checkbox', 'label' => false, 'div' => false, 'style' => 'margin-top:50px', 'checked' => 'checked', 'value' => $diff_value['system']['Product']['id']); ?>
                        <?php echo $this->Form->input("Update.{$diff_value['system']['Product']['id']}.Product.id", $opts); ?>
                    </td>
                    <td><?php echo $diff_value['system']['Product']['title']; ?></td>
                    <td>
                        <?php echo empty($diff_value['system']['Product']['barcode']) ? __d('cms', 'brak danych') . '<br/>' : $diff_value['system']['Product']['barcode']; ?>
                        <span style="margin-left: 50%">&middot;</span><br/>
                        <?php echo empty($diff_value['system']['Product']['code']) ? __d('cms', 'brak danych') . '<br/>' : $diff_value['system']['Product']['code']; ?>
                    </td>
                    <td><?php echo $diff_value['system']['Product']['producer']; ?></td>
                    <td><?php echo empty($brands[$diff_value['system']['Product']['brand_id']]) ? "" : $brands[$diff_value['system']['Product']['brand_id']]; ?></td>
                    <td>
                        <?php
                        foreach ($diff_value['system']['ProductsCategory'] as $item) {
                            $id = $item['id'];
                            echo $productCategoriesList[$id] . "<br/>";
                        }
                        ?>
                    </td>
                    <td><?php echo $diff_value['system']['Product']['size']; ?></td>
                    <td><?php echo $diff_value['system']['Product']['sized']; ?></td>
                    <td>
                        <?php
                        $gender = $diff_value['system']['Product']['gender'];
                        if ($gender == 'w') {
                            echo __d('cms', 'Kolekcja damska');
                        } else if ($gender == 'm') {
                            echo __d('cms', 'Kolekcja męska');
                        } else {
                            echo __d('cms', 'Nie określono');
                        }
                        ?>
                    </td>
                    <td><?php echo $diff_value['system']['Product']['weight']; ?></td>
                    <td><?php echo $diff_value['system']['Product']['quantity']; ?></td>
                    <td><?php echo $diff_value['system']['Product']['execution_time']; ?></td>
                    <td><?php echo $this->Number->currency($diff_value['system']['Product']['price'], '', array('places' => 2, 'decimals' => ',', 'thousands' => "")); ?></td>
                    <td><?php echo $diff_value['system']['Product']['tax']; ?></td>
                    <td>
                        <?php
                        if (!empty($diff_value['system']['Product']['promoted']) && $diff_value['system']['Product']['promoted'] == 1) {
                            echo __d('cms', 'Promowany na stronie głównej') . "<br/>";
                        }
                        if (!empty($diff_value['system']['Product']['sale']) && $diff_value['system']['Product']['sale'] == 1) {
                            echo __d('cms', 'Wyprzedaż') . "<br/>";
                        }
                        if (!empty($diff_value['system']['Product']['on_blog']) && $diff_value['system']['Product']['on_blog'] == 1) {
                            echo __d('cms', 'Promowany na blogu') . "<br/>";
                        }
                        ?>
                    </td>
                    <!--<td><?php // echo $this->Text->truncate($diff_value['system']['Product']['content'], 100);  ?></td>-->
                </tr>
                <tr>
                    <?php $diffClass = $diff_value['system']['Product']['title'] == $diff_value['csv']['Product']['title'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo $diff_value['csv']['Product']['title'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.title", array('value' => $diff_value['csv']['Product']['title']));
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.url", array('value' => $diff_value['csv']['Product']['img']));
                        ?>
                    </td>
                    <?php
                    if ($diff_value['system']['Product']['barcode'] != $diff_value['csv']['Product']['barcode'] || $diff_value['system']['Product']['code'] != $diff_value['csv']['Product']['code']) {
                        $diffClass = 'class="difference"';
                    } else {
                        $diffClass = "";
                    }
                    ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo empty($diff_value['csv']['Product']['barcode']) ? __d('cms', 'brak danych') . '<br/>' : $diff_value['csv']['Product']['barcode'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.barcode", array('value' => $diff_value['csv']['Product']['barcode']));
                        ?>
                        <div style="text-align: center">&middot;</div>
                        <?php
                        echo empty($diff_value['csv']['Product']['code']) ? __d('cms', 'brak danych') . '<br/>' : $diff_value['csv']['Product']['code'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.code", array('value' => $diff_value['csv']['Product']['code']));
                        ?>
                    </td>
                    <?php $diffClass = $diff_value['system']['Product']['producer'] == $diff_value['csv']['Product']['producer'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo $diff_value['csv']['Product']['producer'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.producer", array('value' => $diff_value['csv']['Product']['producer']));
                        ?>
                    </td>
                    <td>
                        <?php $opts = array('options' => $brands, 'label' => false, 'empty' => "Wybierz markę", 'default' => $diff_value['csv']['Brand']['id']); ?>
                        <?php echo $this->Form->input("Update.{$diff_value['csv']['Product']['id']}.Brand.id", $opts); ?>
                    </td>
                    <td>
                        <?php $opts = array('options' => $productCategoriesList, 'label' => false, 'empty' => "Wybierz kategorie", 'default' => $diff_value['csv']['ProductCategory']['id']); ?>
                        <?php echo $this->Form->input("Update.{$diff_value['csv']['Product']['id']}.ProductCategory.id", $opts); ?>
                    </td>
                    <?php $diffClass = $diff_value['system']['Product']['size'] == $diff_value['csv']['Product']['size'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>><?php echo $diff_value['csv']['Product']['size']; ?></td>
                    <?php $diffClass = $diff_value['system']['Product']['sized'] == $diff_value['csv']['Product']['sized'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>><?php echo $diff_value['csv']['Product']['sized']; ?></td>
                    <?php $diffClass = $diff_value['system']['Product']['gender'] == $diff_value['csv']['Product']['gender'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        $gender = $diff_value['csv']['Product']['gender'];
                        if ($gender == 'w') {
                            echo __d('cms', 'Kolekcja damska');
                        } else if ($gender == 'm') {
                            echo __d('cms', 'Kolekcja męska');
                        } else {
                            echo __d('cms', 'Nie określono');
                        }
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.gender", array('value' => $gender));
                        ?>
                    </td>
                    <?php $diffClass = $diff_value['system']['Product']['weight'] == $diff_value['csv']['Product']['weight'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo $diff_value['csv']['Product']['weight'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.weight", array('value' => $diff_value['csv']['Product']['weight']));
                        ?>
                    </td>
                    <?php $diffClass = $diff_value['system']['Product']['quantity'] == $diff_value['csv']['Product']['quantity'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo $diff_value['csv']['Product']['quantity'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.quantity", array('value' => $diff_value['csv']['Product']['quantity']));
                        ?>
                    </td>
                    <?php $diffClass = $diff_value['system']['Product']['execution_time'] == $diff_value['csv']['Product']['execution_time'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo $diff_value['csv']['Product']['execution_time'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.execution_time", array('value' => $diff_value['csv']['Product']['execution_time']));
                        ?>
                    </td>
                    <?php $diffClass = $diff_value['system']['Product']['price'] == $diff_value['csv']['Product']['price'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo $this->Number->currency($diff_value['csv']['Product']['price'], '', array('places' => 2, 'decimals' => ',', 'thousands' => " "));
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.price", array('value' => $diff_value['csv']['Product']['price']));
                        ?>
                    </td>
                    <?php $diffClass = $diff_value['system']['Product']['tax'] == $diff_value['csv']['Product']['tax'] ? "" : 'class="difference"'; ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        echo $diff_value['csv']['Product']['tax'];
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.tax", array('value' => $diff_value['csv']['Product']['tax']));
                        ?>
                    </td>
                    <?php
                    if ($diff_value['system']['Product']['promoted'] != $diff_value['csv']['Product']['promoted'] || $diff_value['system']['Product']['sale'] != $diff_value['csv']['Product']['sale'] ||
                            $diff_value['system']['Product']['on_blog'] != $diff_value['csv']['Product']['on_blog']) {
                        $diffClass = 'class="difference"';
                    } else {
                        $diffClass = "";
                    }
                    ?>
                    <td <?php echo $diffClass; ?>>
                        <?php
                        if (!empty($diff_value['csv']['Product']['promoted']) && $diff_value['csv']['Product']['promoted'] == 1) {
                            echo __d('cms', 'Promowany na stronie głównej') . "<br/>";
                        }
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.promoted", array('value' => $diff_value['csv']['Product']['promoted']));
                        if (!empty($diff_value['csv']['Product']['sale']) && $diff_value['csv']['Product']['sale'] == 1) {
                            echo __d('cms', 'Wyprzedaż') . "<br/>";
                        }
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.sale", array('value' => $diff_value['csv']['Product']['sale']));
                        if (!empty($diff_value['csv']['Product']['on_blog']) && $diff_value['csv']['Product']['on_blog'] == 1) {
                            echo __d('cms', 'Promowany na blogu') . "<br/>";
                        }
                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.on_blog", array('value' => $diff_value['csv']['Product']['on_blog']));
                        ?>
                        <?php echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.content", array('value' => $diff_value['csv']['Product']['content'])); ?>
                    </td>
                    <?php //$diffClass = $diff_value['system']['Product']['content'] == $diff_value['csv']['Product']['content'] ? "" : 'class="difference"'; ?>
                    <!--<td <?php //echo $diffClass;  ?>>-->
                    <?php
//                        echo $this->Text->truncate($diff_value['csv']['Product']['content'], 100);
//                        echo $this->Form->hidden("Update.{$diff_value['csv']['Product']['id']}.Product.content", array('value' => $diff_value['csv']['Product']['content']));
                    ?>
                    <!--</td>-->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>




    <h3><?php echo __d('public', 'Nowe produkty:'); ?></h3>
    <table class="new">
        <thead>
            <tr>
                <th><?php echo __d('cms', 'Id'); ?></th>
                <th><?php echo __d('cms', 'Title'); ?></th>
                <th>
                    <?php echo __d('cms', 'Kod kreskowy'); ?>
                    <span style="margin-left: 50%">&middot;</span><br/>
                    <?php echo __d('cms', 'Kod produktu'); ?>
                </th>
                <th><?php echo __d('cms', 'Producent'); ?></th>
                <th><?php echo __d('cms', 'Marka'); ?></th>
                <th><?php echo __d('cms', 'Kategoria'); ?></th>
                <th><?php echo __d('cms', 'Rozmiary produktu'); ?></th>
                <th><?php echo __d('cms', 'Produkt rozmiarowy'); ?></th>
                <th><?php echo __d('cms', 'Kolekcja damska/męska'); ?></th>

                <th><?php echo __d('cms', 'Waga [g]'); ?></th>
                <th><?php echo __d('cms', 'Ilość'); ?></th>
                <th><?php echo __d('cms', 'Czas realizacji<br/> zamówienia'); ?></th>
                <th><?php echo __d('cms', 'Cena'); ?></th>
                <th><?php echo __d('cms', 'Podatek'); ?></th>
                <th>
                    <?php echo __d('cms', 'Promowany na stronie głównej'); ?><br/>
                    <?php echo __d('cms', 'Wyprzedaż'); ?><br/>
                    <?php echo __d('cms', 'Promowany na blogu'); ?>
                </th>
                <!--<th><?php // echo __d('cms', 'Opis');  ?></th>-->
            </tr>
        </thead>
        <tbody>
            <?php $productNewId = 1; ?>
            <?php foreach ($productsFromCsv['NEW'] as $csv_value): ?>
                <tr>
                    <td>
                        <?php echo $this->Form->hidden("New.{$productNewId}.Product.id", array('value' => "")); ?>
                    </td>
                    <td>
                        <?php
                        echo $csv_value['Product']['title'];
                        echo $this->Form->hidden("New.{$productNewId}.Product.title", array('value' => $csv_value['Product']['title']));
                        echo $this->Form->hidden("New.{$productNewId}.Product.url", array('value' => $csv_value['Product']['img']));
                        ?>
                    </td>
                    <td>
                        <?php echo empty($csv_value['Product']['barcode']) ? __d('cms', 'brak danych') . '<br/>' : $csv_value['Product']['barcode']; ?>
                        <?php echo $this->Form->hidden("New.{$productNewId}.Product.barcode", array('value' => $csv_value['Product']['barcode'])); ?>
                        <span style="margin-left: 50%">&middot;</span><br/>
                        <?php echo empty($csv_value['Product']['code']) ? __d('cms', 'brak danych') . '<br/>' : $csv_value['Product']['code']; ?>
                        <?php echo $this->Form->hidden("New.{$productNewId}.Product.code", array('value' => $csv_value['Product']['code'])); ?>
                    </td>
                    <td>
                        <?php echo $csv_value['Product']['producer']; ?>
                        <?php echo $this->Form->hidden("New.{$productNewId}.Product.producer", array('value' => $csv_value['Product']['producer'])); ?>
                    </td>
                    <td>
                        <?php $opts = array('options' => $brands, 'label' => false, 'empty' => "Wybierz markę", 'default' => $csv_value['Brand']['id']); ?>
                        <?php echo $this->Form->input("New.{$productNewId}.Brand.id", $opts); ?>
                    </td>
                    <td>
                        <?php $opts = array('options' => $productCategoriesList, 'label' => false, 'empty' => "Wybierz kategorie", 'default' => $csv_value['ProductCategory']['id']); ?>
                        <?php echo $this->Form->input("New.{$productNewId}.ProductCategory.id", $opts); ?>
                    </td>
                    <td>
                        <?php echo $csv_value['Product']['size']; ?>
                        <?php echo $this->Form->hidden("New.{$productNewId}.Product.size", array('value' => $csv_value['Product']['size'])); ?>
                    </td>
                    
                    <td>
                        <?php echo $csv_value['Product']['sized']; ?>
                        <?php echo $this->Form->hidden("New.{$productNewId}.Product.sized", array('value' => $csv_value['Product']['sized'])); ?>
                    </td>
                    <td>
                        <?php
                        //echo $csv_value['Product']['gender'];
                        $gender = $csv_value['Product']['gender'];
                        if ($gender == 'w') {
                            echo __d('cms', 'Kolekcja damska');
                        } else if ($gender == 'm') {
                            echo __d('cms', 'Kolekcja męska');
                        } else {
                            echo __d('cms', 'Nie określono');
                        }

                        echo $this->Form->hidden("New.{$productNewId}.Product.gender", array('value' => $csv_value['Product']['gender']));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $csv_value['Product']['weight'];
                        echo $this->Form->hidden("New.{$productNewId}.Product.weight", array('value' => $csv_value['Product']['weight']));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $csv_value['Product']['quantity'];
                        echo $this->Form->hidden("New.{$productNewId}.Product.quantity", array('value' => $csv_value['Product']['quantity']));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $csv_value['Product']['execution_time'];
                        echo $this->Form->hidden("New.{$productNewId}.Product.execution_time", array('value' => $csv_value['Product']['execution_time']));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Number->currency($csv_value['Product']['price'], '', array('places' => 2, 'decimals' => ',', 'thousands' => " "));
                        echo $this->Form->hidden("New.{$productNewId}.Product.price", array('value' => $csv_value['Product']['price']));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $csv_value['Product']['tax'];
                        echo $this->Form->hidden("New.{$productNewId}.Product.tax", array('value' => $csv_value['Product']['tax']));
                        ?>
                    </td>
                    <td>
                        <?php
                        if (!empty($csv_value['Product']['promoted']) && $csv_value['Product']['promoted'] == 1) {
                            echo __d('cms', 'Promowany na stronie głównej') . "<br/>";
                        }
                        echo $this->Form->hidden("New.{$productNewId}.Product.promoted", array('value' => $csv_value['Product']['promoted']));
                        if (!empty($csv_value['Product']['sale']) && $csv_value['Product']['sale'] == 1) {
                            echo __d('cms', 'Wyprzedaż') . "<br/>";
                        }
                        echo $this->Form->hidden("New.{$productNewId}.Product.sale", array('value' => $csv_value['Product']['sale']));
                        if (!empty($csv_value['Product']['on_blog']) && $csv_value['Product']['on_blog'] == 1) {
                            echo __d('cms', 'Promowany na blogu') . "<br/>";
                        }
                        echo $this->Form->hidden("New.{$productNewId}.Product.on_blog", array('value' => $csv_value['Product']['on_blog']));
                        ?>
                        <?php echo $this->Form->hidden("New.{$productNewId}.Product.content", array('value' => $csv_value['Product']['content'])); ?>
                    </td>
                    <!--<td>-->
                    <?php
                    //echo $this->Text->truncate($csv_value['Product']['content'], 100);
                    //echo $this->Form->hidden("New.{$productNewId}.Product.content", array('value' => $csv_value['Product']['content']));
                    ?>
                    <!--</td>-->
                </tr>
                <?php $productNewId++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->Form->end(__d('cms', 'Aktualizuj dane')); ?>
<?php endif; ?>

    
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Product'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'Import csv z subiekta'), array('action' => 'import'), array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Pobierz szablon csv'), '/files/doc/template.csv', array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Import pliku csv'), array('action' => 'csv_import'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
    
    
    
    
<script>
    /**
     * Funkcja w momencie wysyłania formularza kasuje pola hidden jeśli
     * checkbox z danego wiersza nie jest zaznaczony
     */
    $('#ProductAdminCsvImportForm').submit(function() {
        var categoryReady = 1;

        $('.update tr td :checkbox:checked').parent().parent().next().find('select').each(function() {
            var value = $(this).attr('value');
            if (value == "") {
                categoryReady = 0;
            }
        });
        $('.new tr td select').each(function() {
            var value = $(this).attr('value');
            if (value == "") {
                categoryReady = 0;
            }
        });

        if (categoryReady) {
            $(':checkbox:not(:checked)').each(function() {
                var tmp2 = $(this).parent().parent().find(':hidden').remove();
                var tmp = $(this).parent().parent().next();
                tmp.find(':hidden').remove();
            });
            $(':checkbox:not(:checked)').remove();
        } else {
            var msg = '<?php echo __d('cms', 'Ustaw kategorie i marki dla produktów'); ?>';
            alert(msg);
            return false;
        }
    });
    function test() {
        $(':checkbox:not(:checked)').each(function() {
            var tmp2 = $(this).parent().parent().find(':hidden').remove();
            var tmp = $(this).parent().parent().next();
            tmp.find(':hidden').remove();
        });
        $(':checkbox:not(:checked)').remove();
    }
    $(function() {
        $('select').each(function() {
            var value = $(this).attr('value');
            if (value == "") {
                $(this).parent().parent().css('background-color', 'red');
            }
        });
    })
    $('select').change(function() {
        var tmp = $(this).attr('value');
        if (tmp == "") {
            $(this).parent().parent().css('background-color', 'red');
        } else {
            $(this).parent().parent().css('background-color', '');
        }
    });
</script>