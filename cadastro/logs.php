<div class="container" style="margin-top:20px">
	<div class="row">
    	<div class="col-sm-12">
       	<h3> LOGS </h3>
       
       	
       	<table class="table table-bordered table-striped table-sm">
       	<thead>
	      	<tr>
	        <th>Login</th>
	        <th>IP</th>
	        <th>Mensagem</th>
	       
	      	</tr>
    	</thead>
    	<tbody>
		<?php
      	$cst ="SELECT * from `log` order by id_log DESC";/*desc para mostrar em ordem decrescente, maior p menor  */ 
		$re=mysqli_query($con, $cst);
		while ($linha = mysqli_fetch_array($re, MYSQLI_BOTH)){
		echo "<tr> <td>$linha[login]</td>
		<td>$linha[ip] </td> 
		<td>$linha[mensagem] </td>
		
		</tr>";
			} ?>
		</tbody>
		</table>
      	
      	</div>
    </div>
</div>