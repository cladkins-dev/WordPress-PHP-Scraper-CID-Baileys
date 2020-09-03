<?php

include '../wp-load.php';

function getElementById($id)
{
    $xpath = new DOMXPath($this->domDocument);
    return $xpath->query("//*[@id='$id']")->item(0);
}

if($_POST["submit"]){
    $url = $POST['url'];
    $handle = curl_init();

  // Set the url
  curl_setopt($handle, CURLOPT_URL, $_POST['url']);
  // Set the result output to be a string.
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

  $output = curl_exec($handle);

  curl_close($handle);


  $DOM = new DOMDocument;
     @$DOM->loadHTML($output);
     $text="";
     //get all H1
     $items = $DOM->getElementById('ctl02_ctl00_ctl00_DataList1');
     $text.=("</br>".$DOM->getElementById("ctl02_ctl00_ctl00_lnkVehicleName")->nodeValue."</br>\n");
     $text.=("Carfax Buy Back Guarantee</br>\n");
     if(intval($_POST['owners'])>0){
       $text.=((intval(($_POST['owners'])>=1)?$_POST['owners']." Owners":"1 Owner")."</br>\n");
     }
     if(isset($_POST['accidents'])&&intval($_POST['accidents'])==0){
       $text.="No Accidents"."</br>\n";
     }

     $text = preg_replace('/^[ \t]*[\r\n]+/m', '', $text);


     $text.="</br>\n";
     //$text.=("This excellent vehicle comes equipped with the following:</br>");
     //$text.=$features=(str_replace("\n","</br>",$items->nodeValue));



     $text.=($_POST['ad']);
     $text.="</br>";
    $text.="</br>";

    $text.="This excellent vehicle comes equipped with the following:</br>\n";
    $text.="</br>\n";
     $features=$items->nodeValue;

     $features = preg_replace('/^[ \t]*[\r\n]+/m', '', $features);
     $features=preg_replace('/^(.+)(\s*)$/m', '<li>$1</li>', $features);

     $text.=($features);
     //$text.=("<ul><li>".str_replace("</n>","<li>",$features)."</li></ul>");

     $text.="</br>\n";
     $text.=("If you are looking for great service and a good product, then Bailey’s Auto Sales is the place for you. </br>Please call us today or come by, we look forward to working with you. </br>We are located at 7406 East 46 street, Tulsa, Oklahoma. </br>74145 or 918-740-6724\n");
     $text.="</br>\n";
     $text.="</br>\n";
     $text.=("Bailey’s Auto Sales</br>7406 East 46th St.</br>Tulsa OK,74145</br>918-740-6724</br>www.BaileysAutoSale.com\n");
     $text.="</br>\n";
     $features=$items->nodeValue;
     $text.=($features);
    // $text.=("<ul><li>".str_replace("</br>","<li>",$features)."</li></ul>");



     //print("<textarea rows='20' cols='100'>".$text."</textarea>");

     // Create post object
     $PageGuid = site_url() . "/my-page-req1";

$my_post = array(
  'post_title'    => $DOM->getElementById("ctl02_ctl00_ctl00_lnkVehicleName")->nodeValue,
  'post_content'  => $text,
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_category' => array(8,39),
  'post_type' => 'page'
);

// Insert the post into the database
$result=wp_insert_post( $my_post );
if(is_int($result)){
  $link="<a target='_blank' href=".get_permalink( $result).">".$DOM->getElementById("ctl02_ctl00_ctl00_lnkVehicleName")->nodeValue."</a>";
}
//var_dump($result);

  //echo $output;

}
?>
<html>
<head>
  <title>Car Page Scraper</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
  <body>
      <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Bailey's AD Generator</a>

      </nav>

      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block bg-light sidebar">

          </nav>

          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

            </div>


            <h2>Create Advertisment</h2>
            <div class="col-md-9">
            </br>
            </br>
            <form method="post" action="">
            <table>
            <?php
            if($link){
            ?>
            <div class="alert alert-success" role="alert">
              New AD LINK : <?php echo $link;?>
            </div>
            <?php
          };
            ?>

            <tr>
            <th>URL</th>
            <td><input name="url" type="text" value="<?php echo $_POST['url'];?>"></td>
            </tr>
            <tr>
            <th>AD Body:</th>
            <td><textarea name="ad" rows="10" cols="50"><?php echo $_POST['ad'];?></textarea></td>
            </tr>
            <tr>
            <th># Owners:</th>
            <td><input name="owners" type="text" value="<?php echo $_POST['owners'];?>"></td>
            </tr>
            <tr>
            <th># Accidents:</th>
            <td><input name="accidents" type="text" value="<?php echo ($_POST['accidents']>=1)?$_POST['accidents']:-1;?>"></td>
            </tr>
            <tr>
            <th>Generate</th>
            <td><input type="submit" name="submit"></td>
            </tr>

            </table>

            </form>
            </div>

          </main>
        </div>
      </div>

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
      <script src="../../assets/js/vendor/popper.min.js"></script>
      <script src="../../dist/js/bootstrap.min.js"></script>

      <!-- Icons -->
      <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
      <script>
        feather.replace()
      </script>


</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</html>
