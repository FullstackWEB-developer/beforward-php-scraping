<?php
include_once('simple_html_dom.php');

function scraping_DB($url) {
    // create HTML DOM
    $html = file_get_html($url);

    // // get title
    // $ret['Title'] = $html->find('title', 0)->innertext;

    // // get rating
    // $ret['Rating'] = $html->find('div[class="general rating"] b', 0)->innertext;

            $i = 0;
    // get overview
    foreach($html->find('li.car_listitem h2 a') as $a) {
        if($a->href) {
            $i++;
            $sub_url[$i] = $a->href;
        }
        $sub_html = file_get_html($sub_url[$i]);
        
        // $key = '';
        // $val = '';

        //*[@id="contents_detail"]/div[3]/ul/li[2]/h1
        foreach($sub_html->find('ul.title, div.contentLeft a[target=_blank], div.contentLeft/div.carDetails') as $node) {
            var_dump($node);
            echo "<br/>";
            // if ($node->tag=='h5')
            //     $key = $node->plaintext;

            // if ($node->tag=='a' && $node->plaintext!='more')
            //     $val .= trim(str_replace("\n", '', $node->plaintext));

            // if ($node->tag=='text')
            //     $val .= trim(str_replace("\n", '', $node->plaintext));
        }

    }
    
    // clean up memory
    $html->clear();
    unset($html);

    // return $ret;
}
//*[@id="tr_BS5529"]/div[1]/div[1]/div[1]/h2/a
// xpath_eval(*[@id="tr_BS5529"]/div[1]/div[1]/div[1]/h2/a)

// -----------------------------------------------------------------------------
// test it!
// $ret = scraping_DB('http://imdb.com/title/tt0335266/');

for ($pageid=1; $pageid < 2; $pageid++) { 
// for ($pageid=1; $pageid < 320; $pageid++) { 
    // $ret = scraping_DB("https://www.beforward.jp/stocklist/alt_port_id=32/from_stocklist=1/mfg_year_from=2014/page=$pageid/protection=1/sortkey=d/steering=Right/tp_country_id=27/view_cnt=100");
    $ret = scraping_DB("https://www.sbtjapan.com/used-cars/?steering=right-hand-drive&drive=0&year_f=2014&cc_f=0&cc_t=0&mile_f=0&mile_t=0&trans=0&savel=0&saveu=0&fuel=0&color=0&bodyLength=0&loadClass=0&engineType=0&location=&port=0&search_box=1&locationIds=0&d_country=26&d_port=52&ship_type=0&FreightChk=yes&currency=2&inspection=yes&insurance=1&sort=2&psize=25&p_num=$pageid#listbox");
    echo $pageid."end"."<br/>";
}

// $fp = fopen('DB.csv', 'w');
// fputcsv($fp, $ret)
// foreach($ret as $k=>$v)
//     echo '<strong>'.$k.' </strong>'.$v.'<br>';
// ?>