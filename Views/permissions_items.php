<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permissões
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       <div class="box">
        	<div class="box-header">
        		<h3 class="box-title">Items de Permissão</h3>
        		<div class="box-tools">
                    <a href="<?php echo BASE_URL.'permissions/items_add'; ?>" class="btn btn-success">Adicionar</a>
        		</div>
        	</div>
        	<div class="box-body">
        		
        		<table class="table">
        			<tr>
        				<th>Nome do Item</th>
                        <th>Slug</th>
        				<!--<th width="150">Qtd. de ativos</th>-->
        				<th width="130">Ações</th>
        			</tr>

        			<?php foreach($list as $item): ?>
        				<tr>
        					<td><?php echo utf8_encode($item['name']); ?></td>
                            <td><?php echo $item['slug']; ?></td>
        					<!--<td><?php //echo $item['total_users']; ?></td>-->
        					<td>
        						<div class="btn-group">
        							<a href="<?php echo BASE_URL.'permissions/items_edit/'.$item['id']; ?>" class="btn btn-xs btn-primary">Editar</a>
                                    
        							<a href="<?php echo BASE_URL.'permissions/items_del/'.$item['id']; ?>" class="btn btn-xs btn-danger">Excluir</a>
        						</div>
        					</td>
        				</tr>
        			<?php endforeach; ?> 

        		</table>

        	</div>
        </div>
       <h4 class="obs">OBS: Somente items sem links serão excluídos!</h4> 
    </section>
    
    <!-- /.content -->