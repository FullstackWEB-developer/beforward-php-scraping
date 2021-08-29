<?php
include_once('../../simple_html_dom.php');

function scraping_DB($url)
{
    // create HTML DOM
    $html = file_get_html($url);
    $fp = fopen('DB.csv', 'a+');
    $i = 0;

    // get overview
    foreach ($html->find('div.caritem_titlearea h2 a') as $a) {
        if ($a->href) {
            $i++;
            $sub_url[$i] = $a->href;
        }
        $sub_html = file_get_html($sub_url[$i]);

        foreach ($sub_html->find('ul.title h1, p.showMore a[target=_blank], div[class^=carDetails] table[class=tabA]') as $node) {
            if ($node->tag == 'h1')
                $ret['title'] = $node->plaintext;

            if ($node->tag == 'a') {
                $ret['downloadLink'] = $node->href;
            }

            if ($node->tag == 'table' && $node->find('tr', 9)) {
                $ret['Stock Id'] = $node->find('tr', 0)->find('td', 0)->plaintext;
                $ret['Inventory Location'] = $node->find('tr', 0)->find('td', 1)->plaintext;
                $ret['Model Code'] = $node->find('tr', 1)->find('td', 0)->plaintext;
                $ret['Year'] = $node->find('tr', 1)->find('td', 1)->plaintext;
                $ret['Transmission'] = $node->find('tr', 2)->find('td', 0)->plaintext;
                $ret['Color'] = $node->find('tr', 2)->find('td', 1)->plaintext;
                $ret['Drive'] = $node->find('tr', 3)->find('td', 0)->plaintext;
                $ret['Door'] = $node->find('tr', 3)->find('td', 1)->plaintext;
                $ret['Steering'] = $node->find('tr', 4)->find('td', 0)->plaintext;
                $ret['Seats'] = $node->find('tr', 4)->find('td', 1)->plaintext;
                $ret['Engine Type'] = $node->find('tr', 5)->find('td', 0)->plaintext;
                $ret['Body Type'] = $node->find('tr', 5)->find('td', 1)->plaintext;
                $ret['Engine Size'] = $node->find('tr', 6)->find('td', 0)->plaintext;
                $ret['Mileage'] = $node->find('tr', 6)->find('td', 1)->plaintext;
                $ret['Fuel'] = $node->find('tr', 7)->find('td', 0)->plaintext;
                $ret['Body Length'] = $node->find('tr', 7)->find('td', 1)->plaintext;
                $ret['Curb Weight'] = $node->find('tr', 8)->find('td', 0)->plaintext;
                $ret['Gross Vehicle Weight'] = $node->find('tr', 8)->find('td', 1)->plaintext;
                $ret['Max Loading Capacity'] = $node->find('tr', 9)->find('td', 0)->plaintext;
            }
        }
        
        fputcsv($fp, $ret);
    }
    // clean up memory
    $html->clear();
    unset($html);
    fclose($fp);
}

// -----------------------------------------------------------------------------
// pagenation loop

for ($pageid = 1; $pageid < 320; $pageid++) {
    $ret = scraping_DB("https://www.sbtjapan.com/used-cars/?steering=right-hand-drive&drive=0&year_f=2014&cc_f=0&cc_t=0&mile_f=0&mile_t=0&trans=0&savel=0&saveu=0&fuel=0&color=0&bodyLength=0&loadClass=0&engineType=0&location=&port=0&search_box=1&locationIds=0&d_country=26&d_port=52&ship_type=0&FreightChk=yes&currency=2&inspection=yes&insurance=1&sort=2&psize=100&p_num=$pageid#listbox");
}

?>

