<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permissões
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <form method="POST" action="<?php echo BASE_URL; ?>permissions/items_edit_action/<?php echo $permission_id; ?>">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Editar Item de Permissão</h3>
                    <div class="box-tools">
                        <input type="submit" class="btn btn-success" value="Salvar"/>
                    </div>
                </div>
                <div class="box-body">
                    
                    <div class="form-group">
                        <div class="form-group <?php echo (in_array('name', $errorItems))?'has-error':''; ?>">
                            <label for="item_name">Nome do Item</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $permission_items_name; ?>" />
                            <label for="item_name">Slug</label>
                            <input type="text" class="form-control" placeholder="Não editável" disabled/>
                        </div>
                    </div>
                    <hr/>                    
                </div>
            </div>
    </form>
    </section>
    <!-- /.content -->