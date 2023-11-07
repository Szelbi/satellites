import $ from 'jquery';

//Selectors
const todoInput = $(".todo-input");
const todoList = $(".todo-list");


//Event Listeners
$(function() {
    $('#todo-input-field').trigger('focus');
});

$('.todo-type-switch-btn').each(function() {
    $(this).on("click", function() {
        filterTodo();
    });
});


let todoItems = [];

function renderTodoItem(todo) {

    let newTodoItem = $('<li>').addClass("todo-item");

    if (todo.isDone)
        newTodoItem.toggleClass('completed');

    let todoValue = $('<input>').addClass('todo-value').attr({
        id: todo.id,
        value: todo.label
    });

    let doneButton = $('<button>').addClass('todo-btn todo-btn-done').html('<i class="fas fa-check-circle"></i>');
    let removeButton = $('<button>').addClass('todo-btn todo-btn-remove').html('<i class="fas fa-trash-alt"></i>');

    newTodoItem.append(todoValue, doneButton, removeButton);
    todoList.append(newTodoItem);

    return newTodoItem;
}

function filterTodo(event) {
    const todos = $('.todo-item');

    todos.each(function() {
        let todo = $(this);
        switch (event.target.value) {
            case "all":
                todo.css('display', 'flex');
                break;
            case "done":
                if (todo.hasClass('completed')) {
                    todo.css('display', 'flex');
                } else {
                    todo.css('display', 'none');
                }
                break;
            case "todo":
                console.log("todo!!");
                if (!todo.hasClass('completed')) {
                    todo.css('display', 'flex');
                } else {
                    todo.css('display', 'none');
                }
                break;
        }
    });
}

function checkLocalStorage(arrayKey) {
    if (localStorage.getItem(arrayKey) === null) {
        return [];
    } else {
        return JSON.parse(localStorage.getItem(arrayKey))
    }
}

function removeTodo(todoId) {
    todoItems = checkLocalStorage('todoitems');
    todoItems = todoItems.filter(item => item.id !== Number(todoId));
    localStorage.setItem('todoitems', toJSON(todoItems));
}

function toggleDone(todoId) {
    let index = todoItems.findIndex(item => item.id === Number(todoId));
    todoItems[index].checked = !todoItems[index].checked;
    localStorage.setItem('todoitems', toJSON(todoItems));
}

function toJSON(array) {
    return JSON.stringify(array);
}

$('.input-form').on("submit", function(event) {
    event.preventDefault();

    let label = $('.todo-input').val().trim();
    if (label !== '') {
        addNewElement(label);
        $('.todo-input').val('');
    }
});

function addNewElement(label) {
    $.ajax({
        url: '/todos',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ label: label }),
        success: function(data) {
            renderTodoItem(data);
        },
        error: function(error) {
            console.error('An error occurred while adding a new element:', error);
        }
    });
}
