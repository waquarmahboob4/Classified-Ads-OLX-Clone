<?php
include_once("includes/functions.php");
?>
<!DOCTYPE html>
<link rel="shortcut icon" type="image/x-icon" href="assets/img/ico/favicon.ico">
<head>
<title>Quick sell | Classifieds Ads</title>
<link rel="shotcuticon" href="assets/img/olx.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css" >
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css"> 
    <link rel="stylesheet" href="assets/css/main.css">  
    <link rel="stylesheet" href="assets/css/responsive.css"> 
    
<script>

    function getareas(cid){
        $(document).ready(function(){
            $.get("getAreas.php?cid="+cid, function(data, status){
                $("#areaDiv").html(data);
            });
        });
    }

</script>
</head>
<body class="bg">

<?php
drawHeader();
?>
       
    <div class=" bg-success control py-4   justify-content-around">
        <div class=" text-center">
        <form method="get" action="index.php" class=" ">
                        <select class="select w-50 p-2  border border-4 rounded" name="Maincategory">
                        <option value='0'>CategoryName</option>
                            <?php
                            $resultcategories=mysqli_query($clink,"SELECT CategoryID , CategoryName FROM categories");
                            while ($rowcategories=mysqli_fetch_assoc($resultcategories)){
                                echo "<option value='{$rowcategories['CategoryID']}'>{$rowcategories['CategoryName']}</option>";
                            }
                            
                            ?>
                        </select>
                        
                        <input type="submit" class="btn bg-primary " value="search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="40" fill="black" class="bi bi-filter" viewBox="0 0 16 16" data-toggle="modal" data-target="#exampleModal">
  <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
  
</svg>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-success text-white ">
        <h2 class="modal-title" id="exampleModalLabel">Price Filter</h2>
        <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
      <a href="index.php?pricedp" class="w-100 my-2  p-2 rounded filterBtn col-sm-12">Lowest price</a><br>
        <a href="index.php?pricepd" class="w-100 my-2 p-2 rounded filterBtn col-sm-12">Highest price</a><br>
       <a  href="index.php?New" class="w-100 my-2 p-2 rounded filterBtn col-sm-12">New</a><br>
      </div>
      
    </div>
  </div>
</div>
                        
            </form>
            
        </div>
    </div>



<section class="ads">
    <div class="container">
        <div class="row ">
        <?php 
                    //Get DB products and display them
                    if (isset($_GET['pricedp'])){
                        $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Price` ASC  ");
                    }else if (isset($_GET['pricepd'])){
                        $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Price` DESC ");
                    }else if (isset($_GET['New'])){
                    $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`AdsID` DESC     ");
                    }else if (isset($_GET['Maincategory'] ) AND $_GET['Maincategory'] !=0){
                        $categoryID =$_GET['Maincategory'];
                        $result = mysqli_query($clink, "SELECT * FROM advertisments , categories where categories.CategoryID= $categoryID and advertisments.CategoryID = categories.CategoryID ");
                    }else {
                        $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Details` ASC   ");

                    }
                    if(mysqli_num_rows($result)>0){
						//Show them

						while($row = mysqli_fetch_assoc($result)){
							if($row['Status'] == 1 || isLogged() == 2 ) {
                            echo "<div class='col-md-4 col-sm-6 '>
                            <div class='card ' > 
                            <img class='' src='assets/img/{$row['Image']}' class='card-img-top' alt='...'>
                            <span class='float-left'> ₹ {$row['Price']}</span>
                                <div class='card-body'>
                                <h5 class='card-title'>{$row['Title']}</h5>
                                <p class='card-text'>{$row['Details']}</p>
                                <a href='pageads.php?ADS-ID={$row['AdsID']}' class='btn btn-primary '>More Details</a>"; 
                                if ($row['Status'] == 1 &&(isLogged() == 2) ){
                                    echo "<a href='adsshoworhide.php?ADS-ID={$row['AdsID']}' class='btn btn-danger ml-2 ' >Hide</a>";
                                }else if  ($row['Status'] == 0 &&(isLogged() == 2) ) {
                                    echo "<a href='adsshoworhide.php?ADS-ID={$row['AdsID']}' class='btn btn-primary ml-2  ' >Show</a>";

                                }
                                echo" </div> </div></div>";
                            }
                        }
						}else{
						outputMessage("No products found in our catalog",'warning');
					}
				?>


        </div>


    </div>
</section>
<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="assets/js/gmaps.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>