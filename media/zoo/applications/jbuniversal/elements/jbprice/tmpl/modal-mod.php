<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Denis Smetannikov <denis@jbzoo.com>
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title><?php echo JText::_('JBZOO_CART_ADD_TO_CART'); ?></title>
        <link rel="stylesheet" href="<?php echo $this->app->path->url('jbassets:css/jbzoo.css'); ?>" type="text/css"/>
        <script src="<?php echo $this->app->path->url('libraries:jquery/jquery.js'); ?>" type="text/javascript"></script>
        <script type="text/javascript">
            jQuery(function($) {
//++++ stop insertg by woojin for radio input select or change quantity++++
                var price_quantity = [, [1, 2], [3, 6], [7, 10]];
//                var price_quantity = [1 > [1, 2], 2 > [3, 6], 3 > [7, 10]];

                function check_quantity(variable) {
                    var pq = price_quantity;
                    if (variable.hasClass("jsPriceIndex")) {
                        var val = parseInt(variable.val());
                        var qua = parseInt(jQuery('.jsQuantity').val(), 10);
//                        for (var i = 1; i <= price_quantity.length; i++) {
//                            if (qua < price_quantity[i][0]) {
//                                qua = price_quantity[i][0];
//                            } else if (qua > price_quantity[i][1]) {
//                                qua = price_quantity[i][1];
//                            }
//                        }
//                        for (var i = 1; i <= pq.length-1; i++) {
                            var qp = pq[val];
//                            if (qua < pq[i][0]) {
//                                qua = pq[i][0];
//                            } else if (qua > pq[i][1]) {
//                                qua = pq[i][1];
//                            }
                            if (qua < qp[0]) {
                                qua = qp[0];
                            } else if (qua > qp[1]) {
                                qua = qp[1];
                            } else {}
//                        }
//                        switch (val) {
//                            case 1:
//                                if (qua < 1) {
//                                    qua = 1;
//                                } else if (qua > 2) {
//                                    qua = 2;
//                                }
//                                break;
//                            case 2:
//                                if (qua < 3) {
//                                    qua = 3;
//                                } else if (qua > 6) {
//                                    qua = 6;
//                                }
//                                break;
//                            case 3:
//                                if (qua < 7) {
//                                    qua = 7;
//                                } else if (qua > 10) {
//                                    qua = 10;
//                                }
//                                break;
//                            default:
//                                val = 0;
//                        }
                        jQuery('.jsQuantity').val(qua);
                    } else
                    if (variable.hasClass("jsQuantity")) {
                        var qua = parseInt(variable.val());
                        var val = 0;
//                        for (var i = 1; i <= price_quantity.length; i++) {
//                            if (qua >= price_quantity[i][0] && qua <= price_quantity[i][1]) {
//                                val = i;
//                            }
//                        }
                        for (var i = 1; i <= pq.length-1; i++) {
                            var qp = pq[i];
//                            if (qua >= pq[i][0] && qua <= pq[i][1]) {
                            if (qua >= qp[0] && qua <= qp[1]) {
                                val = i;
                            }
                        }
//                        switch (true) {
//                            case (qua <= 1 || qua == 2): var val = 1;
//                                break;
//                            case (qua >= 3 && qua <= 6): var val = 2;
//                                break;
//                            case (qua >= 7 && qua <= 10): var val = 3;
//                                break;
//                            default:
//                                var val = 0;
//                        }
                        jQuery(".jsPriceIndex[value='" + val + "']").prop('checked', true);
                    }
                }
//---- stop insertg by woojin for radio input select or change quantity----

                $('.jsCartModal .jsAddToCartButton').click(function() {

                    var ajaxUrl = "<?php echo $addToCartUrl; ?>";
                    var requestParams = {
                        "args": {
                            'quantity': parseInt($('.jsQuantity').val(), 10),
                            'indexPrice': parseInt(jQuery('.jsPriceIndex:checked').val(), 10)
                        }
                    };

                    $.post(ajaxUrl, requestParams, function(data) {
                        parent.jQuery.fn.JBZooPriceToggle("<?php echo $this->identifier; ?>", <?php echo (int) $this->getItem()->id; ?>);
                        parent.jQuery.fancybox.close();
                    }, "json");
                });

                $('.jsCartModal .jsAddToCartButtonGoto').click(function() {

                    var ajaxUrl = "<?php echo $addToCartUrl; ?>";
                    var requestParams = {
                        "args": {
                            'quantity': parseInt($('.jsQuantity').val(), 10),
                            'indexPrice': parseInt(jQuery('.jsPriceIndex:checked').val(), 10)
                        }
                    };

                    $.post(ajaxUrl, requestParams, function(data) {
                        parent.location.href = "<?php echo $basketUrl; ?>";
                    }, "json");
                });

                $('.jsAddQuantity').click(function() {
                    var quantity = parseInt($('.jsQuantity').val(), 10);
                    quantity++;
                    $('.jsQuantity').val(quantity);
//++++ stop insertg by woojin for switch check radio input++++
                    check_quantity($('.jsQuantity'));
//---- stop insertg by woojin for switch check radio input----
                    return false;
                });

                $('.jsRemoveQuantity').click(function() {
                    var quantity = parseInt($('.jsQuantity').val(), 10);
                    quantity--;
                    if (quantity <= 0) {
                        quantity = 1;
                    }
                    $('.jsQuantity').val(quantity);
//++++ stop insertg by woojin for switch check radio input++++
                    check_quantity($('.jsQuantity'));
//---- stop insertg by woojin for switch check radio input----
                    return false;
                });

                $('.jsGoto').click(function() {
                    var url = $(this).attr('href');
                    parent.location.href = url;
                    return false;
                });

//++++ start inserting by woojin for switch quantity ++++
                jQuery('.jsPriceIndex').on("click", function() {
                    check_quantity(jQuery(this));
                });
//---- stop inserting by woojin for switch quantity ----

            });
        </script>

    </head>
    <body class="jbcart-modal-body">
        <div class="jbzoo">

            <div class="jbcart-modal-window jsCartModal">

                <h1>
                    <a class="jsGoto"
                       href="<?php echo $this->app->route->item($this->getItem()); ?>"><?php echo $this->getItem()->name; ?></a>
                </h1>

                <p class="sku">
                    <strong><?php echo JText::_('JBZOO_CART_ITEM_SKU'); ?></strong>:
<?php echo $this->_getSku(); ?>
                </p>

                <div class="row">
<?php
if (!empty($values)) {

    if (count($values) > 1) {
        echo '<strong>' . JText::_('JBZOO_CART_SELECT') . '</strong>';
    }

    foreach ($values as $key => $price) {

        $value = $this->app->jbmoney->toFormat($price['value'], $currency);

        echo '<div class="price-row"><label>';
        echo '<input name="index" class="jsPriceIndex" type="radio" value="' . $key . '" ' . ($key == 1 ? 'checked = "checked"' : '') . ' /> ';

        if (!($price['value'] == 0 && (int) $this->config->get('basket-nopaid', 0))) {
            echo '<span class="price-value">' . $value . '</span>';
        }

        if (isset($price['description']) && !empty($price['description'])) {
            echo '<span class="price-description">' . $price['description'] . '</span>';
        }

        echo '</label></div>';
    }
}
?>
                    <div class="clear"></div>
                </div>

                <div class="row">
                    <label for="jbzooprice-quantity">
                        <span class="text-quantity"><?php echo JText::_('JBZOO_CART_QUANTITY'); ?></span>
                        <a href="#minus" class="jsRemoveQuantity change-quantity-btn">-</a>
                        <input type="text" id="jbzooprice-quantity" class="jsQuantity" value="1"/>
                        <a href="#plus" class="jsAddQuantity change-quantity-btn">+</a>
                    </label>

                    <div class="clear"></div>
                </div>

                <div class="row row-center">
                    <input type="button" value="<?php echo JText::_('JBZOO_CART_ADD_TO_CART'); ?>"
                           class="jsAddToCartButton add-to-cart-button"/>

<?php if ($basketUrl) : ?>
                        <input type="button" value="<?php echo JText::_('JBZOO_CART_ADD_TO_CART_GOTO_BASKET'); ?>"
                               class="jsAddToCartButtonGoto jbbuttom"/>
                    <?php endif; ?>

                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </body>
</html>
