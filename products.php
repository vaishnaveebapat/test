<?php
// Connect to database
	$connection=mysqli_connect('localhost','root','','api_db');

	$request_method=$_SERVER["REQUEST_METHOD"];

	if(isset($_POST))
	$data = json_decode(file_get_contents("php://input"));
	//print_r($data);
	switch($request_method)
	{
		case 'GET':
			// Retrive Products
			if(!empty($_GET["product_id"]))
			{
				$product_id=intval($_GET["product_id"]);
				get_products($product_id);
			}
			else
			{
				get_products();
			}
			break;
		case 'POST':
			// Insert Product
			insert_product($data);
			break;
		case 'PUT':
			// Update Product
			$product_id=intval($_GET["product_id"]);
			update_product($product_id);
			break;
		case 'DELETE':
			// Delete Product
			$product_id=intval($_GET["product_id"]);
			
			delete_product($product_id);
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	function insert_product($data)
	{
		global $connection;
		/*  $name=$data->name;
		 $description=$data->description;
		 $price=$data->price;
		 $category_id=$data->category_id;
		 $created=$data->created;
		 $modified=$data->modified;
 */

		 $name = $_POST['name'];
        $description=$_POST['description'];
		$price=$_POST['price'];
		//$category_id=$_POST['category_id'];
        $created=$_POST['created'];
		//$modified=$_POST['modified'];   

		$query="INSERT INTO products SET name='{$name}', description='{$description}', price='{$price}', created='{$created}'";
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Product Added Successfully.',
				'data'=>$data
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Product Addition Failed.'
			);
		}
		header('Content-Type: application/json');
		//return  json_encode($response);

		echo json_encode($response);
	}
	function get_products($product_id=0)
	{
		global $connection;
		$query="SELECT * FROM products";
		if($product_id != 0)
		{
			$query.=" WHERE id='".$product_id."' LIMIT 1";
		}
		$response=array();
		$result=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$response[]=$row;
		}
		header('Content-Type: application/json');
        echo json_encode($response);
        
	}
	function delete_product($product_id)
	{
		global $connection;
		
		$query="DELETE FROM products WHERE id=".$product_id;
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Product Deleted Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Product Deletion Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	function update_product($product_id)
	{
		global $connection;
		parse_str(file_get_contents("php://input"),$post_vars);


		$name = $post_vars['name'];
        $description=$post_vars['description'];
		$price=$post_vars['price'];
		//$category_id=$post_vars['category_id'];
        $created=$post_vars['created'];
		//$modified=$post_vars['modified'];

		$query="UPDATE products SET name='{$name}', description='{$description}', price='{$price}', created='{$created}' WHERE id=".$product_id;
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Product Updated Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Product Updation Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	// Close database connection
	mysqli_close($connection);
?>