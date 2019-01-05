<?php
    include('__autoload.php');
    header('Content-type: text/html; charset=UTF-8') ;
    ini_set("default_charset", 'utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./Css/CssIndex.css">
</head>
<body>
<table class="link" border="1" style="border-collapse:collapse; width:900px;margin:auto">
    <tr>
         <td style=" text-align:center; font-weight:bold; font-size:20px; color: blue;">Một số link test tham khảo</td>
    </tr>
    <tr>
         <td>https://vietnamnet.vn/vn/thoi-su/chinh-tri/giam-doc-so-gtvt-tp-hcm-duoc-bo-nhiem-lam-truong-ban-quan-ly-duong-sat-do-thi-499478.html</td>
    </tr>
    <tr>
         <td>https://vietnamnet.vn/vn/thoi-su/ha-noi-doi-xay-nha-cao-tang-vuot-quy-dinh-tren-dat-vang-sat-ho-guom-499607.html</td>
    </tr>
    <tr>
         <td>https://vietnamnet.vn/vn/giai-tri/nhac/huong-tram-doi-dau-voi-erik-justatee-tai-zing-music-awards-499456.html</td>
    </tr>
    <tr>
         <td>https://vnexpress.net/thoi-su/ong-bui-xuan-cuong-quay-lai-lam-truong-ban-quan-ly-duong-sat-do-thi-tp-hcm-3863288.html</td>
    </tr>
    <tr>
         <td>https://vnexpress.net/kinh-doanh/chung-khoan-my-lao-doc-vi-apple-3863326.html</td>
    </tr>
    <tr>
         <td>https://vnexpress.net/the-gioi/my-canh-bao-cong-dan-than-trong-khi-toi-trung-quoc-3863310.html</td>
    </tr>
</table>

<form action="" method="post" style="margin-top:20px;text-align:center;" >
    <input type="text" style={background:red} name='link' placeholder='Nhập url VnExpress tại đây' >
    <input type="submit" name='submit' value='Tách Dữ liệu'>
</form>

<?php
 if (isset($_POST['submit'])){
     $a = $_POST['link'];
     $b = strpos($a, 'https://vnexpress.net/');
    if ($b === false) {
        $b = strpos($a, 'https://vietnamnet.vn/');
        if ($b === false) {
            echo '<span>Link bạn nhập không hợp lệ. Bạn phải nhập link từ 2 trang vnexpress.net và vietnamnet.vn</span>';
        } else {
            $c = new VietnamNet();
            $c -> url = $a;
            // gán giá trị cho các biến title và content
            $title = $c -> takeTitle();
            $content = $c -> takeContent();
            $data = array(
                'Title'   => $title,
                'Content' => $content,
            );
            $d = new WordWithDatabase();
            $d -> insert('data_vietnamnet', $data);
            }
     } else {
        $c = new VnExpress();
        $c->url = $a;
        // gán giá trị cho các biến title và content
        $title = $c->takeTitle();
        $content = $c->takeContent();
        $data = array(
            'Title'   => $title,
            'Content' => $content,
        );
        // var_dump($content);
        $d = new WordWithDatabase();
        $d->insert('data_vnexpress', $data);
            }
    } 
?>

<table class="show_data" border='1' style="border-collapse:collapse">
    <tr style="text-align:center;font-size:25px;font-weight:bold;">
        <td colspan='4'>Data VietnamNet </td>
    </tr>
    <tr style="text-align:center;">
        <td >ID</td>
        <td >Title</td>
        <td>Content</td>
        <td>Delete</td>
    </tr>
    <?php
         $e = new WordWithDatabase();
         $sql1 = 'SELECT * FROM data_vietnamnet';
         $x=$e->getList($sql1);
//  var_dump($x);die();
            // release data
         foreach($e->getList($sql1) as $key=>$value)
         {
             echo '<tr>';
             echo "<td>".$value['Id']."</td>";
             echo "<td>".$value['Title']."</td>";
             echo "<td><a href=\"./Action/ShowContent.php?table=data_vietnamnet&id=".$value['Id']."\">Show Content</a></td>";
             echo "<td><a href=\"./Action/DeleteNews.php?table=data_vietnamnet&id=".$value['Id']."\">Xóa bài</a></td></tr>";
         }
    ?>
</table>

<table class="show_data" border='1' style="border-collapse:collapse">
    <tr style="text-align:center;font-size:25px;font-weight:bold;">
        <td colspan='4'>Data VnExpress </td>
    </tr>
    <tr style="text-align:center;">
        <td >ID</td>
        <td >Title</td>
        <td>Content</td>
        <td>Delete</td>
    </tr>
    <?php
         $e = new WordWithDatabase();
         $sql1 = 'SELECT * FROM data_vnexpress';
         $e->getList($sql1);
         foreach($e->getList($sql1) as $key=>$value)
         {
             echo '<tr>';
             echo "<td>".$value['Id']."</td>";
             echo "<td>".$value['Title']."</td>";
             echo "<td><a href=\"./Action/ShowContent.php?table=data_vnexpress&id=".$value['Id']."\">Show Content</a></td>";
             echo "<td><a href=\"./Action/DeleteNews.php?table=data_vnexpress&id=".$value['Id']."\">Xóa bài</a></td></tr>";
         }
    ?>
</table>
</body>
</html>

