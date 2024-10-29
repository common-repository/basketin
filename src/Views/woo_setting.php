<div class="wrap">
    <h2>BasketIn Setting</h2>

    <form method="POST">
        <table class="form-table" role="presentation">

            <tbody>
                <tr>
                    <th scope="row"><label for="_basket"><?php echo __('Basket'); ?></label></th>
                    <td><input name="basket" type="text" id="_basket" class="regular-text" value="<?php echo esc_attr(get_option('basket_basket')) ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><label for="_token"><?php echo __('Token') ?></label></th>
                    <td><input name="token" type="text" id="_token" class="regular-text" value="<?php echo esc_attr(get_option('basket_token')) ?>">
                        <p class="description">You can get Basket Token from basket setting.</p>
                    </td>
                </tr>

            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Submit') ?>"></p>
    </form>

</div>