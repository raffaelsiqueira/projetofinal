<!DOCTYPE>


<!-- AAAAAAAAAAAAAAAAAAAAAAAAA -->

<html>

	<head>
		
	 <link rel="stylesheet" type="text/css" href="modeloImpacto.css"> 

		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

		<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
		<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>

		<!-- for testing with local version of cytoscape.js -->
		<!--< src="../cytoscape.js/build/cytoscape.js"></>-->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<script src="https://cdn.rawgit.com/cpettitt/dagre/v0.7.4/dist/dagre.min.js"></script>
		<script src="https://cdn.rawgit.com/cytoscape/cytoscape.js-dagre/1.1.2/cytoscape-dagre.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- Chart js implementado aqui     -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>


	<!-- font awesome -->
		<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link href="dashboard.css" rel="stylesheet">

	<!-- Coisas que eu tive que importar para a formatação da barra funcionar. Rever o que precisa ou não -->

		 <meta charset="utf-8">
   		 <meta name="viewport" content="width=device-width, initial-scale=1">
   		 <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
     	 <link href="barra.css" rel="stylesheet" />

    <!-- Google login -->

    	<script src="https://apis.google.com/js/platform.js" async defer></script>

    	<meta name="google-signin-client_id" content="318842794290-2m1dl9daegafau6mcc1d1lpjm4jkv3h1.apps.googleusercontent.com">




		<script>

		//Informações básicas do perfil do Google recuperadas aqui

		var GoogleURL=null;
		function onSignIn(googleUser) {
			var profile = googleUser.getBasicProfile();
			console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
		 	console.log('Name: ' + profile.getName());
		 	console.log('Image URL: ' + profile.getImageUrl());
			console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.


			//Criação da imagem que aparece no gráfico e na topbar
		 	document.getElementById("idDaImagem").src = profile.getImageUrl();
		 	GoogleURL = document.getElementById("idDaImagem").src;
		 	graph(); 		//Necessidade de chamar o gráfico em uma função para recuperar os dados da imagem
		}

		function graph(){

		//Declaração das variáveis com window para que estejam dentro de um escopo global
		window.selectedNode = 0;
			$(function(){
				window.cy = window.cy = cytoscape({
					container: document.getElementById('cy'),
          boxSelectionEnabled: false,
          autounselectify: true,
           wheelSensitivity: 0.1,
					layout: {
						name: 'dagre'
					},
					style: [
						{
							selector: 'node',
							style: {
								'shape': 'circle',
								'content': 'data(idNome)',
								'text-opacity': 0.5,
								'text-valign': 'center',
								'text-halign': 'right',
								'background-color': '#a9a9a9'
							}
						},
						{
							selector: 'edge',
							style: {
								'width': 1,
								'target-arrow-shape': 'triangle',
								'line-color': '#9dbaea',
								'target-arrow-color': '#9dbaea',
								'curve-style': 'bezier'
							}
						},
						{
							//Imagem do google a ser exibida no mapa
							selector:'#googleUserImage',
      				style:{
      					'background-image': 'url('+GoogleURL+')',
      					'background-fit': 'cover',
      					'width': '12px',
      					'height': '12px'
      					}
      		  }

					],
					elements: {
						nodes: [
							{ data: { id: '0' , nivel: 0, description: '', type: '', metric: 0} },
						],
						edges: []
					},
					
				});
				cy.zoom(4);
				
				
				cy.add([
								{ group: "nodes", data: {id: 'googleUserImage', level: 100  }, 
										position: {x: cy.getElementById(selectedNode).position("x")+18, y: cy.getElementById(selectedNode).position("y")-18},

										selected:false,
										selectable:false,
										grabbable: false

									},
									{ group: "edges", data: {}}
						]);


				cy.on('click','node', function(e){
					selectedNode = e.cyTarget.id();

					cy.nodes().style('border-width', 'none');
					cy.nodes().style('border-color', 'white');
					cy.getElementById(selectedNode).style('border-width', '1');
					cy.getElementById(selectedNode).style('border-color', 'black');
					$('#textArea1').val(cy.getElementById(selectedNode).data("description"));



						//movimenta a imagem do Google para seguir o nó selecionado
						//OBS: Se o nó clicado for o da imagem do google, ele desloca infinitamente, consertar esse bug
						cy.nodes("#googleUserImage").positions(function(i, ele){
							return{

								x : cy.getElementById(selectedNode).position("x") +18,
								y : cy.getElementById(selectedNode).position("y") -18

							};
						});
						
					console.log(cy.getElementById(selectedNode).position());
				
				});
			});
		}
		</script> 
	</head>

	<body>



	<!-- Navbar -->

	<nav class="navbar navbar-custom">
			<ul class="nav navbar-nav navbar-left">
		

		    <div class="navbar-container">
      			 <img id= "imaplogo" src="images/imaplogo.png" href="">
      	</div>
   
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">File <i class=" fa-lg icon-folder-open pull-left"></i><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="saveMap.php"><i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>&nbsp; Save map</a></li>
            <li><a href="#" onclick="testeJSON()"><i class="fa fa-upload fa-fw" aria-hidden="true"></i>&nbsp; Load Map</a></li>
            <li><a href="logout.php"><i class="fa fa-user-times  fa-fw" aria-hidden="true"></i>&nbsp; Logout</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Alguma coisa</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Map<i class=" fa-lg icon-sitemap pull-left"></i><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" data-toggle="modal" data-target="#createNodeModal" data-whatever="@mdo"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> Create node (Shift+C)</a></li>
            <!--<li><input type="text" id="nodeName"></li>-->
            <li><a href="#" data-toggle="modal" data-target="#renameNodeModal" data-whatever="@mdo"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Rename selected node (Shift+R)</a></li>
            <li><a href="#" id="remove" onclick="remove()"><i class="fa fa-remove fa-fw" aria-hidden="true"></i> Remove selected node (del)</a></li>
            <li><a href="#" id="center" onclick="center()"><i class="fa fa-search fa-fw" aria-hidden="true"></i> Center map (Shift+M)</a></li>
            <li><a href="#" data-toggle="modal" data-target="#descriptionModal" data-whatever="@mdo"><i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i> Change node description (Shift+D)</a></li>
            <li><a href="#" id="openAltModel" onclick="return openAltModel();"><i class="fa fa-font fa-fw" aria-hidden="true"></i> Open alternative model (Shift+A)</a></li>
            <li><a href='#' id="pdf" onclick="pdf()"><i class="fa fa-file-pdf-o  fa-fw" aria-hidden="true"></i>&nbsp; Export descriptions as PDF</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#"><i class="fa fa-question fa-fw" aria-hidden="true"></i> Help</a></li>
          </ul>
        </li>

         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Share<i class="fa-lg icon-share pull-left"></i><span class="caret"></span></a>
          <ul class="dropdown-menu">
          		<li><a href="#" data-toggle="modal" data-target="#inviteModal" data-whatever="@mdo"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> Invite to colaborate</a></li>
       			<li><a  href="#"><i class="fa fa-share-alt fa-fw" aria-hidden="true"></i>&nbsp; Share</a></li>
       			<li><a href='#' id="pdf" onclick="exportMap()"><i class="fa fa-file-pdf-o  fa-fw" aria-hidden="true"></i>&nbsp; Export map as PDF</a></li> 
          </ul>
        </li>



        	<div class="g-signin2" data-onsuccess="onSignIn"></div>


        	<!-- Imagem do google que fica na topbar -->
					<img id="idDaImagem" src="" style=" height:32px; width: 32px; border-radius: 50%; position:absolute; left:75%" >

       	</li>
      </ul>
         <div>
       		<a class ="textoPagina"> IMPACT MODEL </a>
         </div>

         <div>
         	<a class = "textoPagina2"> Session Participants </a>
         </div>

	</nav>

	<!--Navbar-->
	

	<!-- SIDEBAR -->
 <div id="wrapper" class="active">
      <!-- Sidebar -->
            <!-- Sidebar -->
      <div id="sidebar-wrapper">
      <ul id="sidebar_menu" class="sidebar-nav">
           <li class="sidebar-brand"><a id="menu-toggle" href="#">Menu<span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
      </ul>
        <ul class="sidebar-nav" id="sidebar">     
			
			<li class="panel-group" id="accordion">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Node Description<span class="sub_icon glyphicon glyphicon-text-background"></a>
              <div id="collapseOne" class="panel-collapse collapse in">
             	 <textarea id ="textArea1" rows="3" cols="25" placeholder="Description"></textarea>
              </div>
            </li>

            <li class="panel-group" id="accordion">
              <a  data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" >Impact Result <span class="sub_icon glyphicon glyphicon-exclamation-sign"></a>
              	<div id="collapseTwo" class="panel-collapse collapse in">
              		<textarea id ="textArea2" rows="3" cols="25" placeholder="Impact Result"></textarea>
            	</div>
            </li>

            <li class="panel-group" id="accordion">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Statistic of Contribution <span class="sub_icon glyphicon glyphicon-stats"></a>
    			<div id="collapseThree" class="panel-collapse collapse in">
    				<canvas id="myChart"></canvas>
    			</div>

    					<script>
							var ctx = document.getElementById('myChart').getContext('2d');
					
							var myChart = new Chart(ctx, {
  								type: 'bar',
  								data: {
    								labels: ['First'],
    								datasets: [{
      							label: 'Statistic Of Contribution',
      							data: [12],
      							backgroundColor: "rgba(153,255,51,0.6)"
    								}]
 	 								}
									});
							</script>
            </li>
        </ul>
      </div>
   </div>
    <script type="text/javascript">
      $("#menu-toggle").click(function(e) {
       e.preventDefault();
       $("#wrapper").toggleClass("active");
       $("#cy").toggleClass("active");
      });
    </script>


<!--FOOTER-->
	
	    <footer class="footer">
     		 <div class="containerFooter">
       		 	<span class="text-muted">iMap - Developed by André Tardelli and Raffael Siqueira.</span>
      		</div>
    	</footer>


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
            <input type="text" class="form-control" id="recipient-name" name="update">
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
            <input type="text" class="form-control" id="nodeName" name="add">
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
            <input type="text" class="form-control" id="nodeRename" name="edit">
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

<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="inviteLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="inviteLabel">Invite to colaborate</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Email:</label>
            <input type="text" class="form-control" id="emailInput" name="invite" autofocus>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="invite" onclick="return invite();">Invite</button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="driveUpload" tabindex="-1" role="dialog" aria-labelledby="driveUpload">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="filename" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="renameNodeLabel">Upload</h4>
      </div>
      <div class="modal-body">
        <form action="Google-Drive-PHP-API-Simple-App-Example-master/index.php" method="post" id="formularioUpload">
          <div class="form-group">
            <label for="recipient-name" class="control-label">Upload file</label>
            <input type="text" class="form-control" id="filename" name="upload">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="upload" form="formularioUpload" value="submit">Upload</button>

      </div>
    </div>
  </div>
</div>


		<script>
		let i = 0;
		let nId = 1;
		var pressedShift = false;

    $('input').keypress(function (ev) {
        if (ev.which == 13) {
            ev.preventDefault();
            $('#' + $(this).prop('name')).trigger('click');
        }
    });

    $('button').click(function (ev) {
        ev.preventDefault();
        //alert($(this).attr('id') + ' click');
    });
		
		$(document).keyup(function(e){
			if(e.which == 16) pressedShift = false;
		})
		
		$(document).keydown(function(e){
			if(e.which == 16) pressedShift = true;
			if((e.which == 67 || e.keyCode == 67) && pressedShift == true) {
				$('#createNodeModal').modal('show');
			}
		})
		$(document).keydown(function(e){
			if(e.which == 16) pressedShift = true;
			if((e.which == 82 || e.keyCode == 82) && pressedShift == true) {
				$('#renameNodeModal').modal('show');
			}
		})
		$(document).keydown(function(e){
			if(e.which == 46 || e.keyCode == 46){
				remove();
			}
		})
		$(document).keydown(function(e){
			if(e.which == 16) pressedShift = true;
			if((e.which == 77 || e.keyCode == 77) && pressedShift == true) {
				center();
			}
		})
		$(document).keydown(function(e){
			if(e.which == 16) pressedShift = true;
			if((e.which == 68 || e.keyCode == 68) && pressedShift == true) {
				$('#descriptionModal').modal('show');
			}
		})
		$(document).keydown(function(e){
			if(e.which == 16) pressedShift = true;
			if((e.which == 65 || e.keyCode == 65) && pressedShift == true) {
				openAltModel();
			}
		})
	/*	$(document).keypress(function(e) {
		  if(e.charCode == 99) {
		    alert("Você apertou c");
		  }
		}); */
		//let level = 0;
		//console.log(cy.getElementById(selectedNode).children());

    function testeJSON(){
      var textoJSON = JSON.stringify( cy.json() );
      location.href = "generateJSON.php?texto="+textoJSON;
    }

		function exportMap(){
			 var doc = new jsPDF('landscape', 'pt', 'a4');
			 doc.addHTML(document.body,function(){
			 	doc.save("teste.pdf");
			 });
		
		}

		function invite(){
			let email = $('#emailInput').val()
			location.href = "envia_email_gmail.php?email="+email;
		}
		
		function pdf(){
			var doc = new jsPDF();
			let y = 10;
			let x = 20;
			doc.text(cy.getElementById(0).style('content'), 50, y);
			y+=10;
			cy.nodes().forEach(function(node){
				if(node.data('id')!=0){
					doc.text(node.data('type'), 10, y);
					y+=10;
					doc.text(node.style('content') + ': ' + node.data('description'), x, y);
					y+=10;	
				}
				
			});
			doc.save('description.pdf');
		}
	/*	$('#pdf').on('click', function(){
			var doc = new jsPDF()
			doc.text('Hello world!', 10, 10)
			doc.save('descriptions.pdf')
		});  */
		$('#update').on('click', function (){
			let nodeDescription = $("#recipient-name").val();
			//alert(nodeDescription);
			cy.getElementById(selectedNode).data("description", nodeDescription);
			$('#descriptionModal').modal('hide');
		});
		function openAltModel(){
			let nivelNode = cy.getElementById(selectedNode).data("nivel");
			if (nivelNode != 2){
				alert("This node isn't an alternative");
			} 
			else{
				alert("Redirecting to Alternative Model");
				openPage = function(){
					//$_SESSION['alternativeNode'] = cy.getElementById(selectedNode);
					location.href = "modeloAlt.php?Key="+cy.getElementById(selectedNode);
				}
				//javascript:window.location.href="modeloAlt.php";
				javascript:openPage();
			}
		}
		//$("#add").on('click', add());
			function add(){
				let idText = $("#nodeName").val();
				let nivelPai = cy.getElementById(selectedNode).data("nivel");
				if (idText == ''){
					alert("Write the name of the node!");
				}else{
					if (!(cy.nodes().length == 0)){
						cy.add([
							{ group: "nodes", data: {id:  i+1, idNome:idText, level: cy.getElementById(selectedNode).nivel + 1  }, position: {x: cy.getElementById(selectedNode).position("x")+50, y: cy.getElementById(selectedNode).position("y")+50}},
							{ group: "edges", data: { id: 'edge'+i, source: selectedNode, target: i+1}}
						]);
						cy.getElementById(i+1).data("nivel", nivelPai + 1);
						//console.log(cy.getElementById(idText).data("nivel"));
						
						i++;
					}else{
						cy.add([
							{ group: "nodes", data: {id:  idText, idNome:idText  }, position: {x: 0, y: 0}},
						]);
						selectedNode = idText;
						cy.getElementById(selectedNode).style("background-color","#000000");
					}
					$('#createNodeModal').modal('hide');
					$('#createNodeModal').find('.modal-body input').val("")
				}
				var nodeLevel = cy.getElementById(i).data("nivel");
				if(nodeLevel == 1){
					cy.getElementById(i).style('shape', 'triangle');
					cy.getElementById(i).style("background-color","#00FF00");
					cy.getElementById(i).data('type', 'Scenario');
				}
				else if(nodeLevel == 2){
					cy.getElementById(i).style('shape', 'roundrectangle');
					cy.getElementById(i).style("background-color","#FF8C00");	
					cy.getElementById(i).data('type', 'Alternative');
				}
				else if(nodeLevel == 3){
					cy.getElementById(i).style('shape', 'diamond');
					cy.getElementById(i).style("background-color","#0000FF");
					cy.getElementById(i).data('type', 'Implication');
				}
				else if(nodeLevel == 4){
					cy.getElementById(i).style('shape', 'star');
					cy.getElementById(i).style("background-color","#FF0000");
					cy.getElementById(i).data('type', 'Impact');
				}
				
				//cy.fit();
			}
		function remove(){
			var idAtual = cy.getElementById(selectedNode).data("id");
			var arestas = cy.elements('edge[source=idAtual]');
			var temFilho = 0;
			if(cy.getElementById(selectedNode).data("nivel") == 0){
				//alert("Você não pode remover a raiz!");
				alert("Unable to remove parents!");
			}/*else if(arestas!==undefined){
				alert("Voce so pode remover folhas");
			}*/
			else{
				let saveNode = selectedNode;
				let passow = false;
				cy.edges().forEach(function (edge){
					if(edge.source().id() == selectedNode){
						alert("You can only remove leaves");
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
		}
		$("#edit").on ("click",function (){
			let idText = $("#nodeRename").val();
			cy.getElementById(selectedNode).data("idNome", idText);
			$('#renameNodeModal').modal('hide');
			$('#renameNodeModal').find('.modal-body input').val("")
		});
		function center(){
			cy.fit();
		}
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
		<script src="shortcut.js"></script>
		
	</body>

</html>