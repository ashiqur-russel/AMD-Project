<?php require_once '../conn.php';?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <title>Pizza Ordering System</title>
    </head>
    <body> 

    <?php
        $single_row = null;

        //fetching all pizza for showing base pizza in user UI
        $sql = "SELECT * FROM fetch_all_pizza()";
        $pizza_list = pg_query($db, $sql);

        //fetching all available ingredients to show the ingredients detail in user UI
        $sql_ing = "SELECT * FROM fetch_available_ingredient()";
        $ava_ingredient_list = pg_query($db, $sql_ing);

    ?>
        <div class="container">
            <h1 style="text-align: center">Welcome To Pizza Ordering System</h1>
            <div class="col-md-12" style="margin: 10px; width: 100%; height: 340px; border: 2px solid black; float: left">
                <div class="col-md-5" style="float: left;">
                    <div class="row" style="text-align: center"><h3><u>Select Base Pizza</u></h3></div>
                    <div class="col-md-12" style="margin: 10px">
                        <div class="col-md-3">
                            <label for="in_name" style="padding: 7px 00px 0px 20px;">Size</label>    
                        </div>
                        <div class="col-md-5">
                            <select class="form-control" id="pizzaSize" name="pizzaSize">
                                <option selected="selected" disabled>Choose Pizza</option>
                                <?php                                    
                                    // Iterating through the pizza array
                                    while ($item = pg_fetch_assoc($pizza_list)){
                                        $selected = ($item["size"] == $single_row["pizzaSize"]) ? "selected" : "";
                                        echo '<option value="' .$item["size"]. '"'.$selected.'>' . $item["size"] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4" style="padding-top: 7px">cm</div>
                    </div>
                    <div class="col-md-12" style="margin: 10px; text-align: center">
                        <button style="margin-left: 35px;" type="submit" class="btn btn-primary"
                                name="submit">Select</button>
                    </div>
                </div>
                <div class="col-md-7" style="float: left; border-left: 2px solid black; padding: 2px">
                    <div class="row" style="text-align: center"><h3><u>Select Ingredients</u></h3></div>
                    <div class="col-md-12" style="margin: 10px">
                        <div class="col-md-4">
                            <label for="in_name" style="padding: 7px 00px 0px 10px;">Ingredient Name</label>    
                        </div>
                        <div class="col-md-5">
                            <select class="form-control" id="in_name" name="in_name">
                                <option selected="selected" disabled>Choose Ingredient</option>
                                <?php                                    
                                    // Iterating through the pizza array
                                    while ($item = pg_fetch_assoc($ava_ingredient_list)){
                                        $selected = ($item["name"] == $single_row["in_name"]) ? "selected" : "";
                                        echo '<option value="' .$item["name"]. '"'.$selected.'>' . $item["name"] . '</option>';
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button style="margin-left: 30px;" type="submit" class="btn btn-primary"
                                name="submit">Select</button>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin: 10px">
                        <div class="col-md-4">
                            <label for="province" style="padding: 7px 00px 0px 10px;">Re. Provenance</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="province" name="province"
                                value="<?php echo $single_row["province"]; ?>" readonly>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="col-md-12" style="margin: 10px">
                        <div class="col-md-4">
                            <label for="province" style="padding: 7px 00px 0px 10px;">Price</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="price" name="price"
                                value="<?php echo $single_row["price"]; ?>" readonly>
                        </div>
                        <div class="col-md-4" style="padding-top: 7px">€ / Quantity (in Stück)</div>
                    </div>
                    <div class="col-md-12" style="margin: 10px">
                        <div class="col-md-4">
                            <label for="quantity" style="padding: 7px 00px 0px 10px;">Quantity</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="quantity" name="quantity"
                                value="<?php echo $single_row["quantity"]; ?>" placeholder="Enter Quantity">
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="col-md-12" style="margin: 10px; text-align: center">
                        <button style="width: 80px" type="submit" class="btn btn-primary"
                            name="submit">Ok</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin: 10px; width: 100%; border: 2px solid black; float: left">
                <div class="row" style="text-align: center"><h3><u>List of Ingredients</u></h3></div>
                <div class="col-md-12" style="margin: 10px; float: left">
                    <div class="col-md-6" style="float: left">
                        <div class="col-md-4">
                            <label for="pizza_size">Pizza Size : </label>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4" style="padding-top: 7px">cm</div>
                    </div>
                    <div class="col-md-6" style="float: left">
                        <div class="col-md-4">
                            <label for="pizza_size">Pizza Price : </label>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4" style="padding-top: 7px">€</div>
                    </div>
                </div>
                <div class="col-md-12" style="margin: 10px; float: left">
                    <table class="table table-striped">
                        <tr>
                            <th> <font face="Arial">Ingredient Name</font> </th>
                            <th> <font face="Arial">Re. Province</font> </th>
                            <th> <font face="Arial">Price Per Quantity</font> </th>
                            <th> <font face="Arial">Quantity</font> </th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12" style="margin: 10px; float: left">
                    <div class="col-md-6" style="float: left"></div>
                    <div class="col-md-6" style="float: left">
                        <div class="col-md-3" style="float: left">
                            <label for="in_name" style="padding: 7px 00px 0px 0px;">Summation :</label>
                        </div>
                        <div class="col-md-2" style="float: left">
                    
                        </div>
                        <div class="col-md-1" style="padding-top: 7px">€</div>
                    </div>
                </div>
                <div class="col-md-12" style="margin: 10px; float: left">
                    <div class="col-md-6" style="float: left"></div>
                    <div class="col-md-6" style="float: left">
                        <div class="col-md-3" style="float: left">
                            <label for="in_name" style="padding: 7px 00px 0px 0px;">Total Price :</label>
                        </div>
                        <div class="col-md-2" style="float: left">
                    
                        </div>
                        <div class="col-md-1" style="padding-top: 7px">€</div>
                    </div>
                </div>
                <div class="col-md-12" style="margin: 10px; text-align: center">
                    <button type="submit" class="btn btn-primary"
                        name="submit">Order Now</button>
                </div>
            </div>
        </div>
    </body>

</html>