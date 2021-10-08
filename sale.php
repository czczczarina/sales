<link rel="stylesheet" href="style.css">

<?php
    class Sales {

        var $conn;

        public function __construct(){
            $this->dbconnection(); 
        }

        public function checkout($products){  
            $total = 0;

            foreach($products as $key  => $value){
               
                $sql = "update products SET qty = qty - ".$value ." where id = ".$key;
                $this->conn->query($sql);

                $sql_2 = "select price, qty FROM products where id = ".$key;
                $result = array();
                $result = $this->conn->query($sql_2); 

                $x = $result->fetch_assoc();

                $total += ($x['price'] * $value); 
            }

          return $total;
        }
        public function changeinfo($id, $qty, $price){   

           
            if($qty > 0 ){
                $sql_qty = "update products SET qty = ".$qty ." where id = ".$id;
                $this->conn->query($sql_qty);
            }

            if($price > 0 ){  
                $sql_price = "update products SET price = ".$price ." where id = ".$id;
                $this->conn->query($sql_price);
            }

            $this->getProducts();
        }
        
        public function getProducts(){
            $sql = "select *  FROM products";
            $result = $this->conn->query($sql);
             
            if ($result->num_rows > 0) {
                $html_2 = '';
                $html = '<form method="post"  action="">
                            <table id="sales">';
                    $html .= '<tr>';
                            $html .= '<th>Product</th>';
                            $html .= '<th>Stocks</th>';
                            $html .= '<th>Qty</th>';
                            $html .= '<th>Put desired quantity to buy</th>';
                    $html .= '</tr>'; 
                
                $html  .= '<tbody>'; 

                while($row = $result->fetch_assoc()) {
                    $html .= '<tr>';
                        $html .='<td>'. $row['name']. '</td>';
                        $html .='<td>'. $row['qty']. '</td>';
                        $html .='<td>'. $row['price']. '</td>';

                        if($row['price'] == 0 ){  
                            $html .='<td> Not available </td>';
                        }else{
                            $html .='<td>'. '<input type="number"  name="product['.$row['id'].']">'. '</td>';
                        }
                        
                    $html .= '</tr>'; 


                     $html_2 .= '<form  method="post"  action="">';
                        $html_2.= '<div class="change_info">';
                            $html_2 .='<div>'. $row['name']. '</div>';
                            $html_2 .='<div>'. '<input name="qty" value="" placeholder="Set new quantity here" type="number">'. '</div>'; 
                            $html_2 .='<div>'. '<input name="price" placeholder="Set new price here" value="" type="number">'. '</div>';
                            $html_2 .=  '<input name="id" value="'.$row['id'].'" type="hidden">'; 
                            $html_2 .='<div>'. '<input type="submit" name="change_info" value="Submit">'. '</div>';
                        $html_2 .= '</div>'; 
                    $html_2 .= '</form>'; 
                }

                $html .= '<tr>'; 
                            $html .= '<th colspan="4"><input  name="sales" type="submit" value="Submit"></th>';
                    $html .= '</tr>'; 
               
                $html  .= '</tbody>';
                $html .= '</table>
                        </form>'; 
                 
                echo $html;
                echo $html_2;

            } else {
                    echo "No products";
            }
        }

        public function dbconnection(){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db_name = "test";

            
            $this->conn = mysqli_connect($servername, $username, $password, $db_name);
 
            if (!$this->conn) {
                die("Connection failed: " . mysqli_connect_error());
                exit;
            } 
        }

    }


    $sale = new Sales();
     
    if(isset($_POST['sales']) && (isset($_POST['product']) && !empty($_POST['product']))){
       echo 'Total sale: '. $sale->checkout($_POST['product']);
       
       $sale->getProducts();

       exit;
    }else if(isset($_POST['change_info']) && 
                    ((isset($_POST['qty']) && !empty($_POST['qty']) || 
                        isset($_POST['price']) && !empty($_POST['price'])))){

        $id = $_POST['id'];
        $qty = $_POST['qty'];  
        $price = $_POST['price'];
       
        $sale->changeinfo($id, $qty, $price);
 
        exit;
     }
    
    
    else{
        $sale->getProducts();
    }

?>