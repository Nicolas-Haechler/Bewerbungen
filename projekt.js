    // Array zur Speicherung der TODOs
    var todos = [];

   
      // Funktion zum Hinzufügen der Event-Listener für einen "Bearbeiten"-Button
      function addEditButtonListener(button, index) {
        button.addEventListener('click', function(event) {
          event.stopPropagation(); // Hinzufügen dieser Zeile, um die Event-Bubbling-Propagierung zu stoppen
          editTodo(index);
        });
      }

    
      
    // Funktion zum Erstellen eines neuen TODOs
    function createTodo() {
      var createButton = document.getElementById('createButton');
      if (createButton.innerHTML === 'TODO erstellen') {
        var title = document.getElementById('titleInput').value;
        var description = document.getElementById('descriptionInput').value;
        var abbreviation = document.getElementById('abbreviationInput').value;
        var important = document.getElementById('importantInput').checked;
        var urgent = document.getElementById('urgentInput').checked;
        var dueDate = document.getElementById('dueDateInput').value;
        var percentage = document.getElementById('percentageInput').value;

    // Validierung der Eingabefelder
    if (title.trim() === '') {
      alert('Bitte geben Sie einen Titel ein.');
      return;
    }

    if (description.trim() === '') {
      alert('Bitte geben Sie eine Beschreibung ein.');
      return;
    }

    if (abbreviation.trim() === '') {
      alert('Bitte geben Sie ein Kürzel ein.');
      return;
    }

    if (!dueDate) {
      alert('Bitte geben Sie ein Fälligkeitsdatum ein.');
      return;
    }

    if (percentage < 0 || percentage > 100) {
      alert('Bitte geben Sie einen Fortschrittswert zwischen 0 und 100 ein.');
      return;
    }

        var editButton = document.createElement('button');
        editButton.innerHTML = 'Bearbeiten';

        // Priorität berechnen
        var priority;
        if (important && urgent) {
          priority = 'Sofort erledigen';
        } else if (important && !urgent) {
          priority = 'Einplanen und Wohlfühlen';
        } else if (!important && urgent) {
          priority = 'Gib es ab';
        } else {
          priority = 'Weg damit';
        }

        // Neues TODO-Objekt erstellen und zur Liste hinzufügen
        var todo = {
          title: title,
          description: description,
          abbreviation: abbreviation,
          important: important,
          urgent: urgent,
          priority: priority,
          dueDate: dueDate,
          percentage: percentage
        };

        todos.push(todo);
        saveTodosToLocalStorage(); // Speichern der TODOs im Local Storage
        renderTodoList();
        resetInputFields();
      }
      // Seite neu laden
      window.location.reload();
    }

    // Funktion zum Rendern der TODO-Liste
function renderTodoList() {
  var todoList = document.getElementById('todoList');
  todoList.innerHTML = '';

  todos.forEach(function(todo, index) {
    var listItem = document.createElement('li');
    var todoText = '<strong>' + todo.title + '</strong><br>';
    todoText += 'Beschreibung: ' + todo.description + '<br>';
    todoText += 'Kürzel: ' + todo.abbreviation + '<br>';
    todoText += 'Wichtig: ' + (todo.important ? 'Ja' : 'Nein') + '<br>';
    todoText += 'Dringend: ' + (todo.urgent ? 'Ja' : 'Nein') + '<br>';
    todoText += 'Priorität: ' + todo.priority + '<br>';
    todoText += 'Fälligkeitsdatum: ' + todo.dueDate + '<br>';
    todoText += 'Fortschritt: ' + todo.percentage + '%';

    listItem.innerHTML = todoText;

    var editButton = document.createElement('button');
    editButton.innerHTML = 'Bearbeiten';
    addEditButtonListener(editButton, index);

    var deleteButton = document.createElement('button');
    deleteButton.innerHTML = 'Löschen';
    deleteButton.addEventListener('click', function() {
      deleteTodo(index);
    });

    listItem.appendChild(editButton);
    listItem.appendChild(deleteButton);
    todoList.appendChild(listItem);
  });
}

        
    
    // Funktion zum Löschen eines TODOs
    function deleteTodo(index) {
      todos.splice(index, 1);
      saveTodosToLocalStorage(); // Speichern der TODOs im Local Storage
      renderTodoList();
    }

    // Funktion zum Bearbeiten eines TODOs
    function editTodo(index) {
      var todo = todos[index];
      document.getElementById('titleInput').value = todo.title;
      document.getElementById('descriptionInput').value = todo.description;
      document.getElementById('abbreviationInput').value = todo.abbreviation;
      document.getElementById('importantInput').checked = todo.important;
      document.getElementById('urgentInput').checked = todo.urgent;
      document.getElementById('dueDateInput').value = todo.dueDate;
      document.getElementById('percentageInput').value = todo.percentage;

      // Den "TODO erstellen"-Button durch den "TODO speichern"-Button ersetzen
      var createButton = document.getElementById('createButton');
      createButton.innerHTML = 'TODO speichern';
      createButton.removeEventListener('click', createTodo);
      createButton.addEventListener('click', function() {
        saveTodoChanges(index);
      });
    }

    // Funktion zum Speichern der Änderungen eines TODOs
    function saveTodoChanges(index) {
      var todo = todos[index];
      todo.title = document.getElementById('titleInput').value;
      todo.description = document.getElementById('descriptionInput').value;
      todo.abbreviation = document.getElementById('abbreviationInput').value;
      todo.important = document.getElementById('importantInput').checked;
      todo.urgent = document.getElementById('urgentInput').checked;
      todo.dueDate = document.getElementById('dueDateInput').value;
      todo.percentage = document.getElementById('percentageInput').value;

      // Priorität aktualisieren
      if (todo.important && todo.urgent) {
        todo.priority = 'Sofort erledigen';
      } else if (todo.important && !todo.urgent) {
        todo.priority = 'Einplanen und Wohlfühlen';
      } else if (!todo.important && todo.urgent) {
        todo.priority = 'Gib es ab';
      } else {
        todo.priority = 'Weg damit';
      }

      saveTodosToLocalStorage(); // Speichern der TODOs im Local Storage
      renderTodoList();
      restoreCreateButton();

      // Seite neu laden
      window.location.reload();
    }

    // Funktion zum Zurücksetzen des "TODO erstellen"-Buttons
    function restoreCreateButton() {
      var createButton = document.getElementById('createButton');
      createButton.innerHTML = 'TODO erstellen';
      createButton.removeEventListener('click', saveTodoChanges);
      createButton.addEventListener('click', createTodo);
    }

    // Funktion zum Zurücksetzen der Eingabefelder
    function resetInputFields() {
      document.getElementById('titleInput').value = '';
      document.getElementById('descriptionInput').value = '';
      document.getElementById('abbreviationInput').value = '';
      document.getElementById('importantInput').checked = false;
      document.getElementById('urgentInput').checked = false;
      document.getElementById('dueDateInput').value = '';
      document.getElementById('percentageInput').value = '';
    }

    // Event-Listener für den "TODO erstellen"-Button
    document.getElementById('createButton').addEventListener('click', function() {
      createTodo();
    });

    // Event-Listener für den "Suchen"-Button
    document.getElementById('searchButton').addEventListener('click', function() {
      performSearch();
    });

    // Funktion zum Durchführen der Suche
    function performSearch() {
      var searchQuery = document.getElementById('searchInput').value.toLowerCase();
      var filteredTodos = todos.filter(function(todo) {
        var todoText = todo.title.toLowerCase() + todo.description.toLowerCase() + todo.abbreviation.toLowerCase();
        return todoText.includes(searchQuery);
      });

      renderFilteredTodoList(filteredTodos);
    }

    // Funktion zum Rendern der gefilterten TODO-Liste
    function renderFilteredTodoList(filteredTodos) {
      var todoList = document.getElementById('todoList');
      todoList.innerHTML = '';

      filteredTodos.forEach(function(todo, index) {
        var listItem = document.createElement('li');
        var todoText = '<strong>' + todo.title + '</strong><br>';
        todoText += 'Beschreibung: ' + todo.description + '<br>';
        todoText += 'Kürzel: ' + todo.abbreviation + '<br>';
        todoText += 'Wichtig: ' + (todo.important ? 'Ja' : 'Nein') + '<br>';
        todoText += 'Dringend: ' + (todo.urgent ? 'Ja' : 'Nein') + '<br>';
        todoText += 'Priorität: ' + todo.priority + '<br>';
        todoText += 'Fälligkeitsdatum: ' + todo.dueDate + '<br>';
        todoText += 'Fortschritt: ' + todo.percentage + '%';

        listItem.innerHTML = todoText;

        var editButton = document.createElement('button');
        editButton.innerHTML = 'Bearbeiten';
        editButton.addEventListener('click', function() {
          editTodo(index);
        });

        var deleteButton = document.createElement('button');
        deleteButton.innerHTML = 'Löschen';
        deleteButton.addEventListener('click', function() {
          deleteTodo(index);
        });

        listItem.appendChild(editButton);
        listItem.appendChild(deleteButton);
        todoList.appendChild(listItem);
      });
    }

    // Funktion zum Speichern der TODOs im Local Storage
    function saveTodosToLocalStorage() {
      localStorage.setItem('todos', JSON.stringify(todos));
    }

    // Funktion zum Laden der TODOs aus dem Local Storage
    function loadTodosFromLocalStorage() {
      var storedTodos = localStorage.getItem('todos');
      if (storedTodos) {
        todos = JSON.parse(storedTodos);
        renderTodoList();
      }
    }

    // Aufruf der Funktion zum Laden der TODOs aus dem Local Storage
    loadTodosFromLocalStorage();