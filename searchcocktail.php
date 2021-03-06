<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'tpdlrkzn1';
$db_name = 'CocktailInfo';
$db_type = 'mysql';

$dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";

try {
  $pdo = new PDO($dsn, $db_user, $db_pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  if(isset($_POST['cocktailname']) && $_POST['cocktailname'] != "") {
    $cocktailname = '%'.$_POST['cocktailname'].'%';

    $sql = "SELECT Picture, Name FROM Info1 WHERE Name like :Name";

    $stmh = $pdo->prepare($sql);
    $stmh -> bindValue(':Name', $cocktailname, PDO::PARAM_STR);
    $stmh -> execute();

    $count = $stmh->rowCount();

    while($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
      $searchPicture[] = $row['Picture'];
      $searchName[] = $row['Name'];
    }

    $x = 0;
    $y = 0;?>

    <!DOCTYPE html>
    <html>
    <head>
    <title>칵테일: ALL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      .main{
          color: black;
          text-decoration: none;
      }

      .main:hover {
          color: red;
          background-color: transparent;
          text-decoration: underline;
      }
      .main:active {
          color: yellow;
          background-color: transparent;
          text-decoration: underline;
      }

      a {
        color: black;
        text-decoration:none;
      }

      a:hover {
        color: red;
        background-color: transparent;
        text-decoration:underline;
      }

      a:active {
        color: yellow;
        background-color: transparent;
        text-decoration: underline;
      }

      .pagination {
          display: inline-block;
      }

      .pagination a {
          color: black;
          float: left;
          padding: 8px 16px;
          text-decoration: none;
          transition: background-color .3s;
          border: 1px solid #ddd;
          margin: 0 4px;
      }

      .pagination a.active {
          background-color: #333;
          color: white;
          border: 1px solid #333;
      }

      .pagination a:hover:not(.active) {background-color: #ddd;}

      </style>
      </head>
      <body>

      <!--제목-->
      <div style="position:absolute;left:45px;margin-right:10px">
      <h1 style="font-family: courier;font-size:300%">Search of All </h1>
      </div>

      <!--칵테일 선택과 Go to main 버튼-->
      <div style="position:absolute;left:1370px;top:50px;width:150px">
      <img src="logo.png" width = 20px height=20px>
      <a class="main" href="http://1.247.212.109:8012/main.html" title="main으로 가려면 클릭하세요">Go to main</a>

      </div>

      <!--검색 결과 칵테일-->
      <div style="position:absolute;left:265px;top:150px">
      <h3>'<?=htmlspecialchars($_POST['cocktailname'])?>' 에 대한 검색 결과는 <?=htmlspecialchars($count)?> 건 입니다.</h3>
      </div>

      <!--칵테일 사진-->
      <div style="position:absolute;left:265px;top:200px">
      <table border>
        <?php
        for ($i=0; $i < $count/4; $i++) {
          ?>
          <tr>
            <?php
            for ($z=0; $z < 4; $z++) {
              if ($x < $count) {
                ?>
                <td><img src="<?=htmlspecialchars($searchPicture[$x])?>" width=250 height=280></td>

                <?php
                $x = $x + 1;
              }
            } ?>

          </tr>
          <tr align=center>
            <?php
            for ($z=0; $z < 4; $z++) {
              if ($y < $count){
                ?>
                <td><a href="cocktailInformation.php?searchInfo=<?=htmlspecialchars($searchName[$y])?>"><?=htmlspecialchars($searchName[$y])?></a></td>
                <?php
                $y = $y + 1;
              }
            } ?>
          </tr>
          <?php
        } ?>
      </table>
      </div>

    </body>
    </html>
    <?php
  }
}catch (Exception $Exception){
  print "오류 : ".$Exception->getMessage();
}
?>
