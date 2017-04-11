<!DOCTYPE html>
<html>
  <head>
    <title>Google Realtime Quickstart</title>

    <!-- Load Styles -->
    <link href="https://www.gstatic.com/realtime/quickstart-styles.css" rel="stylesheet" type="text/css"/>

    <!-- Load the Realtime API JavaScript library -->
    <script src="https://apis.google.com/js/api.js"></script>
  </head>
  <body>
    <main>
      <h1>Realtime Collaboration Quickstart</h1>
      <p>Welcome to the quickstart in-memory app!</p>
      <textarea id="text_area_1"></textarea>
      <textarea id="text_area_2"></textarea>
      <p>This document only exists in memory, so it doesn't have real-time collaboration enabled. However, you can persist it to your own disk using the model.toJson() function and load it using the model.loadFromJson() function. This enables your users without Google accounts to use your application.</p>
      <textarea id="json_textarea"></textarea>
      <button id="json_button" class="visible">GetJson</button>
    </main>
    <script>
      // Load the Realtime API, no auth needed.
      window.gapi.load('auth:client,drive-realtime,drive-share', start);

      function start() {
        var doc = gapi.drive.realtime.newInMemoryDocument();
        var model = doc.getModel();
        var collaborativeString = model.createString();
        collaborativeString.setText('Welcome to the Quickstart App!');
        model.getRoot().set('demo_string', collaborativeString);
        wireTextBoxes(collaborativeString);
        document.getElementById('json_button').addEventListener('click', function(){
          document.getElementById('json_textarea').value = model.toJson();
        });
      }

      // Connects the text boxes to the collaborative string.
      function wireTextBoxes(collaborativeString) {
        var textArea1 = document.getElementById('text_area_1');
        var textArea2 = document.getElementById('text_area_2');
        gapi.drive.realtime.databinding.bindString(collaborativeString, textArea1);
        gapi.drive.realtime.databinding.bindString(collaborativeString, textArea2);
      }
    </script>
  </body>
</html>