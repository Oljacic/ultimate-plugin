<div class="wrap">
    <h1>Taxonomy Manager</h1>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST["edit_tax"]) ? 'active' : '' ?>"><a href="#tab-1">Your Taxonomies</a></li>
        <li class="<?php echo isset($_POST["edit_tax"]) ? 'active' : '' ?>">
            <a href="#tab-2">
                <?php echo isset($_POST["edit_tax"]) ? 'Edit' : 'Add' ?> Taxonomies
            </a>
        </li>
        <li><a href="#tab-3">Export</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_tax"]) ? 'active' : '' ?>">

            <h3>Manage Your Taxonomies</h3>

            <?php $options = get_option('ultimate_plugin_tax') ?: array(); ?>

            <table class="cpt-table">
                <tr>
                    <th>ID</th>
                    <th>Singular Name</th>
                    <th class="text-center">Hierarchical</th>
                    <th class="text-center">Actions</th>
                </tr>
                <?php foreach($options as $option): ?>
                    <?php
                        $hierarchical = isset($option['hierarchical']) ? 'TRUE' : 'FALSE';
                    ?>
                    <tr>
                        <td><?php echo $option['taxonomy']; ?></td>
                        <td><?php echo $option['singular_name']; ?></td>
                        <td class="text-center"><?php echo $hierarchical; ?></td>
                        <td class="text-center">
                            <form method="post" action="" class="inline-block">
                                <input type="hidden" name="edit_tax" value="<?php echo $option['taxonomy']; ?>">
                                <?php submit_button('Edit', 'primary small', 'submit', false); ?>
                            </form>
                            <form method="post" action="options.php" class="inline-block">
                                <?php settings_fields( 'ultimate_plugin_tax_settings' ); ?>
                                <input type="hidden" name="remove" value="<?php echo $option['taxonomy']; ?>">
                                <?php submit_button('Delete', 'delete small', 'submit', false, array(
                                    'onClick' => 'return confirm("Are you sure you want to delete this Custom Taxonomy? The data associated with it will not be deleted");'
                                )); ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>

        <div id="tab-2" class="tab-pane <?php echo isset($_POST["edit_tax"]) ? 'active' : '' ?>">
            <form method="post" action="options.php">
                <?php
                settings_fields( 'ultimate_plugin_tax_settings' );
                do_settings_sections( 'ultimate_plugin_tax' );
                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-3" class="tab-pane">
            <h3>Export Your Taxonomies</h3>

        </div>
    </div>
</div>