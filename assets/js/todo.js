import $ from 'jquery';

const todoInput = $(".todo-input");
const todoList = $(".todo-list");
let todoItems = [];


$(function() {
    $('#todo-input-field').trigger('focus');
});

$('.todo-type-switch-btn').each(function() {
    $(this).on("click", function(event) {
        filterTodoElements(event);
    });
});

$('.input-form').on("submit", function(event) {
    event.preventDefault();

    let label = $('.todo-input').val().trim();
    if (label !== '') {
        addNewElement(label);
        $('.todo-input').val('');
    }
});


function renderTodoItem(todo) {

    let newTodoItem = $('<li>').addClass("todo-item");

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

function filterTodoElements(e) {
    const todos = $('.todo-item');

    todos.each(function() {
        let todo = $(this);
        switch (e.target.value) {
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
                if (!todo.hasClass('completed')) {
                    todo.css('display', 'flex');
                } else {
                    todo.css('display', 'none');
                }
                break;
        }
    });
}


function removeTodo(todoId) {
    todoItems = todoItems.filter(item => item.id !== Number(todoId));
}

function toggleDone(todoId) {
    let index = todoItems.findIndex(item => item.id === Number(todoId));
    todoItems[index].checked = !todoItems[index].checked;
}

function toJSON(array) {
    return JSON.stringify(array);
}

function addNewElement(label) {
    $.ajax({
        url: '/todos',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ label: label, isDone: false }),
        success: function(data) {
            renderTodoItem(data);
        },
        error: function(error) {
            let message = 'An error occurred while adding a new element.';
            alert(message);
            console.error(message, error);
        }
    });
}
