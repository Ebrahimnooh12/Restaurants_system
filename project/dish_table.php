<?php
extract($_GET);

require("connection.php");
if($type_s !="All" && $rate_s!="All")
$dishsql = "SELECT did,name,type,price,rate,pic,offer,d.fid FROM dish d, category c, offer o WHERE d.ct_id = c.qid and type='$type_s' and rate='$rate_s' GROUP BY did ORDER BY did";

if($type_s !="All" && $rate_s=="All")
$dishsql = "SELECT did,name,type,price,rate,pic,offer,d.fid FROM dish d, category c, offer o WHERE d.ct_id = c.qid and type='$type_s' GROUP BY did ORDER BY did";

if($type_s =="All" && $rate_s!="All")
$dishsql = "SELECT did,name,type,price,rate,pic,offer,d.fid FROM dish d, category c, offer o WHERE d.ct_id = c.qid and rate='$rate_s' GROUP BY did ORDER BY did";

if($type_s =="All" && $rate_s=="All")
$dishsql = "SELECT did,name,type,price,rate,pic,offer,d.fid FROM dish d, category c, offer o WHERE d.ct_id = c.qid  GROUP BY did ORDER BY did";

$dish = $db->query($dishsql);
$count=$dish->rowCount();
//echo "<h1>$ct<h1>";

    $current=$page*12;
    $dishsql=$dishsql." LIMIT $current,12 ";
 $dish = $db->query($dishsql);
 ?>
<div class="shop-product-wrap grid row">   
<?php
foreach($dish as $row) {   
 ?>
     
<div class="col-xl-3 col-lg-4 col-md-6 col-12 pb-30 pt-10">

<!-- dish Start -->
<div class="ee-product">

        <!-- Image -->
        <div class="image">
    
            <!-- <span class="label sale">sale</span> -->
    
            <a href="single-dish.php?d=<?php echo $row["did"]?>" class="img"><img src="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>" width="270" height="320" alt="" onerror=this.src="assets/images/pic/default.jpg"></a>
            <button type="button" class="cart btn btn-outline-warning mt-10 ml-60" onclick="window.location.href='single-dish.php?d=<?php echo $row['did']?>'"><i class="ti-shopping-cart"></i>order</button>
    
        </div>
    
        <!-- Content -->
        <div class="content">
    
            <!-- Category & Title -->
            <div class="category-title">
    
                <a href="#" class="cat"><?php echo $row["type"]?></a>
                <h5 class="title"><a href="single-dish.php"><?php echo $row["name"]?></a></h5>
    
            </div>
    
            <!-- Price & Ratting -->
            <div class="price-ratting">
    
            <?php if($row['fid'] == null){?>
            <h5 class="price"><?php echo $row["price"].'BD'?></h5>
            <?php }
            else {
            ?>
            <h5 class="price"><span class="old"><?php echo $row["price"]?> BD</span><?php echo ($row["price"]-($row["price"] * ($row["offer"] / 100 ))) ?> BD</h5>    
            <?php } ?>

                <div class="ratting">
                <?php for($i=0 ; $i < $row["rate"] ; ++$i)
                            echo "<i class='fa fa-star'></i>";?>
                </div>
    
             </div>
    
        </div>
    
    </div><!-- dish End -->

 </div>
 

<?php 

} 
echo "</div>";
    if($count==0){
        echo "<h3 align='center'>There are no dishes to display</h3><hr>";
    }
    else{
        $count=($count/12);
        $count=ceil($count);
        //$page+=1;
        if($page==0){$nxt=$page+2;}
        else
        $nxt=$page+1;
        
        $prv=$page-1;
    
        echo '<br><br><nav aria-label="..."><ul class="pagination">';
        if($prv>=1)
        echo "<li class='page-item'><button class='page-link' onclick='viewTable($prv)'>Previous</button></li>";
        for($i=0;$i<$count;++$i){
            if(($i)==$page){
                echo "<li class='page-item active disabled'><button class='page-link' onclick='viewTable($i)'>$i</button></li>";
            }
            else{
                echo "<li class='page-item'><button class='page-link' onclick='viewTable($i)'>$i</button></li>";
            }    
        }
        if($count>1 && $nxt!=$count)
        echo "<li class='page-item'><button class='page-link' onclick='viewTable($nxt)'>Next</button></li>";
        echo "<input type='hidden' name='page' value=''/>";
        echo '</ul></nav><br><hr>';
        
    }
?>