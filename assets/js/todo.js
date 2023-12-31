import $ from 'jquery';

const todoList = $(".todo-list");
let todoItems = [];

$(function () {
    $('#todo-input-field').trigger('focus');

    $('.todo-type-switch-btn').each(function () {
        $(this).on("click", function (event) {
            filterTodoElements(event);
        });
    });

    $('.input-form').on("submit", function (event) {
        event.preventDefault();

        const todoInput = $('.todo-input');
        if (todoInput.val().trim() !== '') {
            createTodoAction(todoInput);
        }
    });

    $('.todo-btn-done').on('click', function () {
        toggleDone($(this));
    });

    $('.todo-btn-remove').on('click', function () {
        removeTodo($(this));
    });

});

function renderTodoItem(todo) {

    const newTodoItem = $('<li>', {class: 'todo-item'});

    const todoValue = $('<input>', {
        class: 'todo-value',
        id: todo.id,
        value: todo.label,
    });

    const doneButton = $('<button>', {
        class: 'todo-btn todo-btn-done',
        html: '<i class="fas fa-check-circle"></i>',
    }).on('click', function () {
        toggleDone($(this));
    });

    const removeButton = $('<button>', {
        class: 'todo-btn todo-btn-remove',
        html: '<i class="fas fa-trash-alt"></i>',
    }).on('click', function () {
        removeTodo($(this));
    });

    newTodoItem.append(todoValue, doneButton, removeButton);
    todoList.append(newTodoItem);

    return newTodoItem;
}

function filterTodoElements(e) {
    const todos = $('.todo-item');

    todos.each(function () {
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

function removeTodo(elem) {
    let todoItem = elem.closest('.todo-item');
    let todoId = todoItem.find('.todo-value').attr('id')

    deleteTodoAction(todoId)
        .then(function (success) {
            if (success) {
                todoItem.remove();
            } else {
                console.error('Error while deleting element');
            }
        })
        .catch(function (error) {
            console.error('Server error:', error);
        });

}

function toggleDone(elem) {
    let todoItem = elem.closest('.todo-item');
    let todoId = todoItem.find('.todo-value').attr('id');

    let isDone = todoItem.hasClass('completed');
    if (isDone) {
        todoItem.removeClass('completed');
    } else {
        todoItem.addClass('completed');
    }
    updateTodoAction(todoId, !isDone);

    // let index = todoItems.findIndex(item => item.id === Number(todoId));
    // todoItems[index].checked = !todoItems[index].checked;
}

function createTodoAction(todoInput) {
    const label = todoInput.val().trim();
    $.ajax({
        url: '/todos',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({label: label, isDone: false}),
        success: function (data) {
            renderTodoItem(data);
            todoInput.val('');
        },
        error: function (error) {
            let message = 'An error occurred while adding a new element.';
            alert(message);
            console.error(message, error);
        }
    });
}

function updateTodoAction(todoId, isDone) {

    $.ajax({
        type: 'PATCH',
        url: '/todos/' + todoId,
        contentType: 'application/json',
        data: JSON.stringify({isDone: isDone}),
        success: function () {
            console.log('Todo status updated successfully');
        },
        error: function (error) {
            console.log('Error updating todo status:', error);
        }
    });
}

function deleteTodoAction(todoId) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: 'DELETE',
            url: '/todos/' + todoId,
            success: function () {
                resolve(true);
            },
            error: function () {
                reject(false);
            }
        });
    });
}
