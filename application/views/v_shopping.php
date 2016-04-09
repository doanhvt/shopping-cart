<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Shopping Cart</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">
            function clear_cart() {
                var result = confirm("Có phải bạn muốn xóa giỏ hàng");
                if (result) {
                   window.location = "<?php echo site_url("shopping/remove/all"); ?>";
               }else{
                   return FALSE;
               }
            }
        </script>
    </head>
    <body>
        <section id="cart">
            <div id="heading">
                <h2 style="text-align: center;">GIỎ HÀNG CỦA BẠN</h2>
            </div>
            <div id="text">
                <?php
                $cart = $this->cart->contents();
                if (empty($cart)) {
                    echo 'Giỏ hàng của bạn chưa có sản phẩm nào !';
                } else {
                    ?>
                    <form action="<?php echo site_url("shopping/update_cart"); ?>" method="post">
                        <table id="table" border="0" cellpadding="10px" cellspacing="1px">
                            <tr id="main_heading">
                                <th>Số thứ tự</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Xóa sản phẩm</th>
                            </tr>                   
                            <?php
                            $stt = 0;
                            $total_money = 0;
                            foreach ($cart as $item) {
                                $stt++;
                                $total_money += $item["subtotal"];
                                echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                                echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
                                echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
                                echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
                                echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
                                ?>
                                <tr>
                                    <td><?php echo $stt; ?></td>
                                    <td><?php echo $item["name"]; ?></td>
                                    <td><?php echo number_format($item["price"], 0) . " vnđ"; ?></td>
                                    <td><?php echo form_input('cart[' . $item['id'] . '][qty]', $item['qty'], 'maxlength="3" size="1" style="text-align: right"'); ?></td>
                                    <td><?php echo number_format($item["subtotal"], 0) . " vnđ"; ?></td>
                                    <td><a href="<?php echo site_url() . "shopping/remove/" . $item["rowid"]; ?>">Xóa</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <h3><?php echo "Tổng tiền: " . number_format($total_money, 0); ?></h3>
                        <input type="submit" value="update" />
                        <input type="button" value="delete" onclick="clear_cart()" />
                        <input type="button" value="trade" onclick="window.location='<?php echo site_url("shopping/billing_view"); ?>'"/>
                    </form>               
                    <?php
                }
                ?> 
            </div>   
        </section>
        <section class="homeproduct">
            <?php foreach ($post as $item): ?>     
                <a class="proditem" href="#">
                    <figure>
                        <img src="<?php echo base_url('public/images/' . $item->img); ?>" alt="<?php echo $item->name; ?>" width="120" height="120"/>
                        <span class="textkm"><?php echo $item->title; ?></span>
                        <h4>Price: <?php echo number_format($item->price, 0) . ' vnđ'; ?></h4>
                        <h3><?php echo $item->name; ?></h3>
                        <form action="<?php echo site_url('shopping/add/' . $offset) ?>" method="post" accept-charset="utf-8">
                            <input type="hidden" name="id" value="<?php echo $item->id; ?>"/>
                            <input type="hidden" name="name" value="<?php echo $item->name; ?>"/>
                            <input type="hidden" name="price" value="<?php echo $item->price; ?>"/>                      
                            <p id="add_button"> <input type="submit" name="action" value="Add to Cart" class="fg-button teal"/></p>
                        </form>                          
                    </figure>           
                </a>
            <?php endforeach; ?>    
            <?php echo $paginator; ?>
        </section>
    </body>
</html>