import $ from 'jquery';

$(function() {
    $('#todo-input-field').focus();
});


//Selectors
const todoInput = document.querySelector(".todo-input");
const todoButton = document.querySelector(".todo-btn");
const todoList = document.querySelector(".todo-list");
const filterOption = document.getElementsByClassName("radiobtn-input");


//Event Listeners
document.addEventListener('DOMContentLoaded', load);
todoButton.addEventListener('click', newTodo);
todoList.addEventListener('click', checkOrRemove);
for (let i = 0; i < filterOption.length; i++) {
    filterOption[i].addEventListener('click', filterTodo);
}

let todoItems = [];

//Functions
function newTodo(event) {

    //Prevent site from refreshing
    event.preventDefault();

    let value = todoInput.value.trim();
    if (value !== '') {
        todoInput.value = '';
        todoInput.focus();

        addTodo(value);
    }
}

function addTodo(todoValue) {

    let todo = {
        text: todoValue,
        id: Date.now(),
        checked: false,
    };

    // check if local storage already exists
    todoItems = checkLocalStorage('todoitems');
    todoItems.push(todo);
    localStorage.setItem('todoitems', toJSON(todoItems));

    render(todo);

}

function render(todo) {

    // li
    let todoItem = document.createElement('li');
    todoItem.classList.add("todo-item");
    if (todo.checked)
        todoItem.classList.toggle('completed');
    todoList.appendChild(todoItem);

    // input
    let todoValue = document.createElement('input');
    todoValue.classList.add("todo-value");
    todoValue.id = todo.id;
    todoValue.value = todo.text;
    todoValue.addEventListener('keyup', updateTodoValue);
    todoItem.appendChild(todoValue);

    // button Done
    let doneButton = document.createElement('button');
    doneButton.innerHTML = '<i class="fas fa-check-circle"></i>';
    doneButton.classList.add('todo-btn', 'todo-btn-done');
    todoItem.appendChild(doneButton);

    // button Remove
    let removeButton = document.createElement('button');
    removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
    removeButton.classList.add('todo-btn', 'todo-btn-remove');
    todoItem.appendChild(removeButton);
}

function checkOrRemove(event) {

    let item = event.target;
    let todo = item.parentElement;
    let todoId = todo.children[0].id;

    // console.log(['item', item], ['todo', todo], ['todoValue', todoValue]);


    // delete todo
    if (item.classList[1] === 'todo-btn-remove') {
        todo.classList.toggle('fall');
        todo.addEventListener('transitionend', () => {
            todo.remove();
        })
        removeTodo(todoId);
    }

    // mark todo as done
    if (item.classList[1] === 'todo-btn-done') {
        todo.classList.toggle('completed');
        toggleDone(todoId);
    }
}

function filterTodo(e) {
    const todos = todoList.childNodes;
    // console.log(todos);
    console.log(e.target.value);

    todos.forEach(function (todo) {
        switch (e.target.value) {
            case "all":
                todo.style.display = 'flex';
                break;
            case "done":
                if (todo.classList.contains('completed')) {
                    todo.style.display = 'flex';
                }
                else {
                    todo.style.display = 'none';
                }
                break;
            case "todo":
                console.log("todo!!");
                if (!todo.classList.contains('completed')) {
                    todo.style.display = 'flex';
                }
                else {
                    todo.style.display = 'none';
                }
                break;
        }
    });
}

function checkLocalStorage(arrayKey) {

    //Check if there is any todos already set
    if (localStorage.getItem(arrayKey) === null) {
        return [];
    } else {
        return JSON.parse(localStorage.getItem(arrayKey))
    }
}

function load() {

    const local = localStorage.getItem('todoitems');

    if (local) {

        todoItems = JSON.parse(local);

        todoItems.forEach(obj => {
            render(obj);
        });
    }
}

function removeTodo(todoId) {

    todos = checkLocalStorage('todoitems');

    //removing object from array
    todoItems = todoItems.filter(item => item.id !== Number(todoId));

    // set new array into local storage
    localStorage.setItem('todoitems', toJSON(todoItems));
}

function toggleDone(todoId) {

    todos = checkLocalStorage('todoitems');

    let index = todoItems.findIndex(item => item.id === Number(todoId));

    //
    todoItems[index].checked = !todoItems[index].checked;

    // set new array into local storage
    localStorage.setItem('todoitems', toJSON(todoItems));
}

function updateTodoValue(event) {

    console.log(this.value);
    console.log(this.id);

    todos = checkLocalStorage('todoitems');

    let index = todoItems.findIndex(item => item.id === Number(this.id));
    todoItems[index].text = this.value

    localStorage.setItem('todoitems', toJSON(todoItems));

}

function alertObj(object) {
    alert(JSON.stringify(object, null, 4));
}


function toJSON(array) {
    return JSON.stringify(array);
}
