<!DOCTYPE>

<html>

	<head>
		<!--<title>cytoscape-dagre.js demo</title> -->

		<link rel="stylesheet" type="text/css" href="modeloAlt.css">

		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

		<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
		<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>

		<!-- for testing with local version of cytoscape.js -->
		<!--< src="../cytoscape.js/build/cytoscape.js"></>-->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<script src="https://cdn.rawgit.com/cpettitt/dagre/v0.7.4/dist/dagre.min.js"></script>
		<script src="https://cdn.rawgit.com/cytoscape/cytoscape.js-dagre/1.1.2/cytoscape-dagre.js"></script>

		<!-- Chart js implementado aqui     -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>


		<textarea id ="textArea1" rows="4" cols="40" placeholder="Description">
		</textarea>


		<script>
		var x = 0;
		</script>


		<!--<textarea id ="Tomoyo" name ="Sakura" rows="4" cols="50">
				lalala
		</textarea> -->

	





		<script>
		let selectedNode=0;
			$(function(){
				var cy = window.cy = cytoscape({
					container: document.getElementById('cy'),
          boxSelectionEnabled: false,
          autounselectify: true,
					layout: {
						name: 'dagre'
					},
					style: [
						{
							selector: 'node',
							style: {
								'shape': 'rectangle',
								'content': 'data(idNome)',
								'text-opacity': 0.5,
								'text-valign': 'center',
								'text-halign': 'right',
								'background-color': '#FF8C00'
							}
						},
						{
							selector: 'edge',
							style: {
								'width': 4,
								'target-arrow-shape': 'triangle',
								'line-color': '#9dbaea',
								'target-arrow-color': '#9dbaea',
								'curve-style': 'bezier'
							}
						}
					],
					elements: {
						nodes: [
							{ data: { id: '0' , nivel: 0, description: '', valor: '0'} },
						],
						edges: []
					},
					
				});
				//cy.getElementById(selectedNode).style("background-color","#000000");
				

				cy.zoom(4);

				cy.on('click','node', function(e){
					selectedNode = e.cyTarget.id();
					cy.nodes().style('border-width', 'none');
					cy.nodes().style('border-color', 'white');
					cy.getElementById(selectedNode).style('border-width', '1');
					cy.getElementById(selectedNode).style('border-color', 'black');
					//$('textarea#Tomoyo').val(e.cyTarget.id());
					//var message = $('textarea#Tomoyo').val();
					//alert(message);
   					//alert(document.getElementById("Tomoyo").name);
					//cy.getElementById(e.cyTarget.id()).style("background-color","#000000");
				});
			});
		</script>
	</head>

	<body>


	<!--  IMPLEMENTAÇÃO DO CHART -->


	<div class="chartContainer">
  		<div>
    		<canvas id="myChart"></canvas>
    		<!--<button id="addData" onclick="return addData();">Add Data</button>
    		<button id="removeData">Remove Data</button>-->
  		</div>
	</div>

	<script>

	//var ctx = document.getElementById('myChart').getContext('2d');


	var config ={
  		type: 'radar',
  		data: {
    		labels: [],
    		datasets: [{
      	label: 'Impact Analysis',
      	data: [5],
      	backgroundColor: "rgba(153,255,51,0.6)"
    	}]
 	 }
	}

	//var myChart = new Chart(ctx, config);

	 window.onload = function() {
        window.myRadar = new Chart(document.getElementById("myChart"), config);
    };

	//document.getElementById('addData').addEventListener('click', addData());

		function addData(texto, valor) {
        if (config.data.datasets.length > 0) {
            config.data.labels.push(texto);

            config.data.datasets.forEach(function (dataset) {
                dataset.data.push(valor);
            });

            window.myRadar.update();
        }
    }

	document.getElementById('removeData').addEventListener('click', function() {
        config.data.labels.pop(); // remove the label first

        config.data.datasets.forEach(function(dataset) {
            dataset.data.pop();
        });

        window.myRadar.update();
    });



	</script>





	<!-- <?php
		$descripion = $_POST["description"];
		echo description;
	?> 
	<div><?php echo $output; ?></div> -->



		<nav class="navbar navbar-default">
			<ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">File <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="saveMap.php">Save map</a></li>
            <li><a href="#">Load map</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Alguma coisa</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Map<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" data-toggle="modal" data-target="#createNodeModal" data-whatever="@mdo">Create node</a></li>
            <!--<li><input type="text" id="nodeName"></li>-->
            <li><a href="#" data-toggle="modal" data-target="#renameNodeModal" data-whatever="@mdo">Rename selected node</a></li>
            <li><a href="#" id="remove">Remove selected node</a></li>
            <li><a href="#" id="center">Center map</a></li>
            <li><a href="#" data-toggle="modal" data-target="#descriptionModal" data-whatever="@mdo">Change node description</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Alguma coisa</a></li>
          </ul>
        </li>
      </ul>
	</nav>

		<div class="container-fluid">
		
			<div class="row">
			<div class="col-sm-12">
				<!--<h1>cytoscape-dagre demo</h1>-->
			</div>
			</div>
			<div class="row">
				<!--<div class="col-sm-3 form-inline">
					<div class="form-group">
						<input type="text" class="form-control" class="btn btn-primary" id="textBox">
						<button type = "button" class="btn btn-primary" id="add">Create node</button>
					</div>
				</div>
				<div class="col-sm-2">
					<button type = "button" class="btn btn-primary" id="remove">Remove node</button>
				</div>	
				<div class="col-sm-4 form-inline">
					<div class="form-group">
						<input type="text" class="form-control" id="textBoxEdit">
						<button type = "button" class="btn btn-primary" id = "edit"> Rename node</button>
					</div>
				</div>
				<div class="col-sm-1">
					<button type = "button" class="btn btn-primary" id = "center"> Center map</button>
				</div>
				<div class="col-sm-2">
					<button type = "button" class="btn btn-primary"  data-toggle="modal" data-target="#descriptionModal" data-whatever="@mdo" id = "description"> Show node description</button>
				</div> -->
			</div>
			
					<div id="cy"></div>
				
		</div>

		<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="descriptionModalLabel">Node description</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Description:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>


         	<div class="containerRadio">

         		<h4 class="modal-title2" id="descriptionradio">Valor level</h4>
       			<label class="radio-inline">
         		 <input type="radio" name="inlineRadioOptions" id="Radio1" value="option1">  1
        		</label>
        		<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio2" value="option2"> 2
        		</label>
       			<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio3" value="option3"> 3
        		</label>
        		<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio4" value="option4"> 4
        		</label>
        		<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio5" value="option5"> 5
        		</label>


      		</div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       <!-- <button type="button" class="btn btn-primary" id="openAltModel" onclick="return openAltModel();">Open Alternative Model</button>-->
        <button type="button" class="btn btn-primary" id="update">Update description</button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="createNodeModal" tabindex="-1" role="dialog" aria-labelledby="createNodeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="createNodeLabel">Create node</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Name of the node:</label>
            <input type="text" class="form-control" id="nodeName">
          </div>

          <div class="containerRadio">

         		<h4 class="modal-title2" id="descriptionradio">Valor level</h4>
       			<label class="radio-inline">
         		 <input type="radio" name="inlineRadioOptions" id="Radio1" value="option1">  1
        		</label>
        		<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio2" value="option2"> 2
        		</label>
       			<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio3" value="option3"> 3
        		</label>
        		<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio4" value="option4"> 4
        		</label>
        		<label class="radio-inline">
          		 <input type="radio" name="inlineRadioOptions" id="Radio5" value="option5"> 5
        		</label>


      		</div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add" onclick="return add();">Create node</button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="renameNodeModal" tabindex="-1" role="dialog" aria-labelledby="renameNodeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="renameNodeLabel">Rename node</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">New name of the node:</label>
            <input type="text" class="form-control" id="nodeRename">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit">Rename node</button>

      </div>
    </div>
  </div>
</div>
		<script>
		let i = 0;
		$('#update').on('click', function (){
			let nodeDescription = $("#recipient-name").val();
			//alert(nodeDescription);
			cy.getElementById(selectedNode).data("description", nodeDescription);
			$('#descriptionModal').modal('hide');
		});
		//let level = 0;
		//console.log(cy.getElementById(selectedNode).children());
		//$("#add").on('click',add());

			function add(){
				let idText = $("#nodeName").val();
				let nivelPai = cy.getElementById(selectedNode).data("nivel");
				if (idText == ''){
					alert("Escreva o nome do no!");
				}else{
					if ((!(cy.nodes().length == 0)) && (cy.getElementById(selectedNode).data("nivel") == 0) ){
						cy.add([
							{ group: "nodes", data: {id:  idText, idNome:idText, level: cy.getElementById(selectedNode).nivel + 1  }, position: {x: cy.getElementById(selectedNode).position("x")+50, y: cy.getElementById(selectedNode).position("y")+50}},
							{ group: "edges", data: { id: 'edge'+i, source: selectedNode, target: idText}}
						]);
						cy.getElementById(idText).data("nivel", nivelPai + 1);
						//cy.getElementById(idText).data("valor", )
						//console.log(cy.getElementById(idText).data("nivel"));
						cy
						i++;
						for (x=1; x<=5; x++){
							//let selecionado = document.getElementById("Radio"+x).checked;
							//alert(selecionado);
							$('input:radio[name=inlineRadioOptions]').each(function(){
								if($(this).is(':checked')){
									alert($(this).val());
								}
							});
							if (selecionado){
								cy.getElementById(idText).data('valor',x);
								alert("Radio"+x);

							}
						}
						addData(idText, cy.getElementById(idText).data('valor'));
						$('#createNodeModal').modal('hide');
					    $('#createNodeModal').find('.modal-body input').val("")

					}else{
						alert("Only the main node can be branched");
					}
				}
				var nodeLevel = cy.getElementById(idText).data("nivel");
				if(nodeLevel == 1){
					cy.getElementById(idText).style('shape', 'roundrectangle');
					cy.getElementById(idText).style("background-color","#a9a9a9");
				}
			}
		
		$("#remove").on("click",function (){
			var idAtual = cy.getElementById(selectedNode).data("id");
			var arestas = cy.elements('edge[source=idAtual]');
			var temFilho = 0;
			if(cy.getElementById(selectedNode).data("nivel") == 0){
				//alert("Você não pode remover a raiz!");
				alert("Unable to remove the main node!");
			}/*else if(arestas!==undefined){
				alert("Voce so pode remover folhas");
			}*/
			else{
				let saveNode = selectedNode;
				let passow = false;
				cy.edges().forEach(function (edge){
					if(edge.source().id() == selectedNode){
						alert("Voce só pode remover folhas");
						temFilho=1;
						return;
					}
				});
				cy.edges().forEach(function (edge){
				if(edge.target().id() == selectedNode){
					selectedNode = edge.source().id();
					passow = true;
				}
			});
				if(temFilho==0){
					cy.getElementById(saveNode).remove();
				}
				
				if (!passow){
					if (!(cy.nodes().length == 0)){
						selectedNode = cy.nodes()[0].id();
					}
				}
				//cy.getElementById(selectedNode).style("background-color","#000000");
			}
		});
		$("#edit").on ("click",function (){
			let idText = $("#textBoxEdit").val();
			cy.getElementById(selectedNode).data("idNome", idText);
			$('#renameNodeModal').modal('hide');
			$('#renameNodeModal').find('.modal-body input').val("")
		});
		$("#center").on("click",function (){
			cy.fit();
		});

		$('#descriptionModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient = button.data('whatever') // Extract info from data-* attributes
		  var text = cy.getElementById(selectedNode).data("description");
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('.modal-title').text('Description of ' + cy.getElementById(selectedNode).data("idNome"))
		  modal.find('.modal-body input').val(text)
		});

		$('#createNodeModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient = button.data('whatever') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('.modal-title').text('Creating a new node')
		});

		$('#renameNodeModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient = button.data('whatever') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('.modal-title').text('Renaming a node')
		});
		</script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>

</html>