<x-layouts.app title="Home">
    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-screen">
        <div class="container mx-auto py-12 h-full">
            <div class="flex justify-center items-center h-full">
                <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 mx-6"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="p-6">
                        <h1 class="text-2xl font-bold mb-6 text-gray-800">Todo App</h1>

                        <div class="grid grid-cols-12 gap-2 justify-between mb-6">
                            <div class="flex gap-2 col-span-12 sm:col-span-6">
                                <select id="filter-status"
                                    class="form-select border rounded-lg p-2 w-full sm:max-w-max">
                                    <option value="">Filter by Status</option>
                                    <option value="completed">Completed</option>
                                    <option value="not_completed">Not Completed</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-12 gap-2 col-span-12 sm:col-span-6">
                                <button id="add-task-button"
                                    class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition col-span-12 sm:col-span-4">Add
                                    Task</button>

                                <div class="relative inline-block text-left col-span-12 sm:col-span-4">
                                    <div class="w-full h-full">
                                        <button id="dropdown-button"
                                            class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none disabled:bg-gray-500 w-full h-full"
                                            type="button">
                                            Mark as
                                        </button>
                                    </div>
                                    <div id="dropdown-menu"
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                        <div class="py-1">
                                            <a href="#" id="mark-completed"
                                                class="text-gray-700 block px-4 py-2 text-sm">Mark as Completed</a>
                                            <a href="#" id="mark-uncompleted"
                                                class="text-gray-700 block px-4 py-2 text-sm">Mark as Uncompleted</a>
                                        </div>
                                    </div>
                                </div>



                                <button id="delete-tasks-button"
                                    class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none disabled:bg-gray-500 col-span-12 sm:col-span-4">Delete
                                    Tasks</button>
                            </div>
                        </div>


                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 text-left">
                                            <input type="checkbox" id="select-all" class="form-checkbox">
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Task Title
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Due Date
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Priority
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tasks-table" class="bg-white divide-y divide-gray-200">
                                    @forelse ($tasks as $task)
                                        <tr class="task-row" data-id="{{ $task->id }}"
                                            data-status="{{ $task->completed ? 'completed' : 'not_completed' }}">
                                            <td class="py-4 px-6 text-sm">
                                                <input type="checkbox" class="task-checkbox form-checkbox"
                                                    data-id="{{ $task->id }}">
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-gray-900">
                                                {{ $task->title }}
                                            </td>
                                            <td class="py-4 px-6 text-sm text-gray-500">
                                                {{ $task->due_date }}
                                            </td>
                                            <td class="py-4 px-6 text-sm text-gray-500">
                                                @if ($task->priority === 'low')
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Low</span>
                                                @elseif ($task->priority === 'medium')
                                                    <span
                                                        class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Medium</span>
                                                @else
                                                    <span
                                                        class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">High</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-sm text-gray-500">
                                                @if ($task->completed)
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Completed</span>
                                                @else
                                                    <span
                                                        class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Not
                                                        Completed</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium">
                                                <button
                                                    class="edit-task-button bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition"
                                                    data-id="{{ $task->id }}">Edit</button>
                                                <button
                                                    class="delete-task-button bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 transition"
                                                    data-id="{{ $task->id }}">Delete</button>
                                            </td>
                                        </tr>

                                        <!-- Edit Task Modal -->
                                        <div id="edit-task-modal-{{ $task->id }}"
                                            class="fixed inset-0 bg-gray-800 bg-opacity-50 justify-center items-center hidden">
                                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h2 class="text-2xl font-bold">Edit Task</h2>
                                                    <button class="text-gray-500 hover:text-gray-700 close-modal"
                                                        data-modal-id="edit-task-modal-{{ $task->id }}">
                                                        <i class="fa-solid fa-xmark text-2xl"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('task.update', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="space-y-3">
                                                        <input type="hidden" name="id"
                                                            value="{{ $task->id }}">
                                                        <input type="text" name="title"
                                                            value="{{ $task->title }}"
                                                            class="form-input w-full border rounded-lg p-2"
                                                            placeholder="Task Title" required />
                                                        <input type="date" name="due_date"
                                                            value="{{ $task->due_date }}"
                                                            class="form-input w-full border rounded-lg p-2" />
                                                        <select name="priority"
                                                            class="form-select w-full border rounded-lg p-2">
                                                            <option value="">- Select Priority -</option>
                                                            <option value="low"
                                                                @if ($task->priority === 'low') selected @endif>
                                                                Low
                                                            </option>
                                                            <option value="medium"
                                                                @if ($task->priority === 'medium') selected @endif>
                                                                Medium
                                                            </option>
                                                            <option value="high"
                                                                @if ($task->priority === 'high') selected @endif>
                                                                High
                                                            </option>
                                                        </select>
                                                        <textarea name="description" class="form-textarea w-full border rounded-lg p-2 resize-none"
                                                            placeholder="Task Description">{{ $task->description }}</textarea>
                                                    </div>
                                                    <div class="flex justify-end mt-4">
                                                        <button type="submit"
                                                            class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Delete Task Modal -->
                                        <div id="delete-task-modal-{{ $task->id }}"
                                            class="fixed inset-0 bg-gray-800 bg-opacity-50 justify-center items-center hidden">
                                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h2 class="text-2xl font-bold">Delete Task</h2>
                                                    <button class="text-gray-500 hover:text-gray-700 close-modal"
                                                        data-modal-id="delete-task-modal-{{ $task->id }}">
                                                        <i class="fa-solid fa-xmark text-2xl"></i>
                                                    </button>
                                                </div>
                                                <p class="mb-4">Are you sure you want to delete this task?</p>
                                                <div class="flex justify-end">
                                                    <form action="{{ route('task.destroy', $task->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition">Delete</button>
                                                        <button type="button"
                                                            class="ml-2 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition close-modal"
                                                            data-modal-id="delete-task-modal-{{ $task->id }}">Cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr id="no-data-message">
                                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">No
                                                tasks
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div id="task-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 id="task-modal-title" class="text-2xl font-bold">Add Task</h2>
                <button id="task-modal-close" class="text-gray-500 hover:text-gray-700 close-modal"
                    data-modal-id="task-modal">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <form id="task-form" action="{{ route('task.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <input type="hidden" id="task-id">
                    <input type="text" id="task-title" name="title"
                        class="form-input w-full border rounded-lg p-2" placeholder="Task Title" required />
                    <input type="date" id="task-due-date" name="due_date"
                        class="form-input w-full border rounded-lg p-2" />
                    <select id="task-priority" name="priority" class="form-select w-full border rounded-lg p-2">
                        <option value="">- Select Priority -</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    <textarea id="task-description" name="description" class="form-textarea w-full border rounded-lg p-2 resize-none"
                        placeholder="Task Description"></textarea>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Save
                        Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mark/Unmark Confirmation Modal -->
    <div id="mark-unmark-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modal-title" class="text-2xl font-bold">Confirm Action</h2>
                <button class="text-gray-500 hover:text-gray-700 close-modal" data-modal-id="mark-unmark-modal">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <p id="modal-body" class="mb-4">Are you sure you want to proceed?</p>
            <div class="flex justify-end">
                <form id="mark-unmark-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="ids" value="">
                    <input type="hidden" name="action" value="">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition"
                        type="submit">Confirm</button>
                </form>
                <button
                    class="ml-2 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition close-modal"
                    data-modal-id="mark-unmark-modal">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Delete Tasks Confirmation Modal -->
    <div id="delete-tasks-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Delete Selected Tasks</h2>
                <button class="text-gray-500 hover:text-gray-700 close-modal" data-modal-id="delete-tasks-modal">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <p class="mb-4">Are you sure you want to delete the selected tasks?</p>
            <div class="flex justify-end">
                <form id="delete-tasks-form" action="{{ route('task.multiple_delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" value="">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition"
                        type="submit">Confirm</button>
                </form>
                <button
                    class="ml-2 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition close-modal"
                    data-modal-id="delete-tasks-modal">Cancel</button>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownButton = document.getElementById('dropdown-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            dropdownButton.addEventListener('click', (e) => {
                e.preventDefault();
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.getElementById(modalId).classList.add('flex');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.remove('flex');
                document.getElementById(modalId).classList.add('hidden');
            }

            function updateButtonsState() {
                const selectedCount = document.querySelectorAll('.task-checkbox:checked').length;
                const markCompletedButton = document.getElementById('dropdown-button');
                const deleteTasksButton = document.getElementById('delete-tasks-button');
                markCompletedButton.disabled = selectedCount === 0;
                deleteTasksButton.disabled = selectedCount === 0;
            }

            document.getElementById('add-task-button').addEventListener('click', () => {
                openModal('task-modal');
            });

            document.querySelectorAll('.close-modal').forEach(button => {
                button.addEventListener('click', (e) => {
                    const modalId = e.currentTarget.getAttribute('data-modal-id');
                    closeModal(modalId);
                });
            });

            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('fixed') && e.target.id.startsWith('task-modal')) {
                    closeModal(e.target.id);
                }
                if (e.target.classList.contains('fixed') && e.target.id.startsWith('edit-task-modal')) {
                    closeModal(e.target.id);
                }
                if (e.target.classList.contains('fixed') && e.target.id.startsWith('delete-task-modal')) {
                    closeModal(e.target.id);
                }
                if (e.target.classList.contains('fixed') && e.target.id.startsWith('mark-unmark-modal')) {
                    closeModal(e.target.id);
                }
                if (e.target.classList.contains('fixed') && e.target.id.startsWith('delete-tasks-modal')) {
                    closeModal(e.target.id);
                }
            });

            document.querySelectorAll('.edit-task-button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const taskId = e.currentTarget.getAttribute('data-id');
                    const modalId = `edit-task-modal-${taskId}`;
                    openModal(modalId);
                });
            });

            document.querySelectorAll('.delete-task-button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const taskId = e.currentTarget.getAttribute('data-id');
                    const modalId = `delete-task-modal-${taskId}`;
                    openModal(modalId);
                });
            });

            document.getElementById('select-all').addEventListener('change', (e) => {
                const checked = e.target.checked;
                document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                    checkbox.checked = checked;
                });
                updateButtonsState();
            });

            document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    updateButtonsState();
                });
            });

            function filterTasks(status) {
                let visibleTasks = false;

                document.querySelectorAll('.task-row').forEach(row => {
                    const taskStatus = row.getAttribute('data-status');
                    if (status === '' || taskStatus === status) {
                        row.classList.remove('hidden');
                        visibleTasks = true;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                const noDataMessage = document.getElementById('no-data-message');
                if (!visibleTasks) {
                    if (!noDataMessage) {
                        const message = document.createElement('td');
                        message.colSpan = 6;
                        message.id = 'no-data-message';
                        message.textContent = 'No tasks found';
                        message.className = 'text-center text-red-500 py-4';
                        document.getElementById('tasks-table').insertAdjacentElement('beforebegin', message);
                    }
                } else {
                    if (noDataMessage) {
                        noDataMessage.remove();
                    }
                }
            }

            document.getElementById('filter-status').addEventListener('change', (e) => {
                const status = e.target.value;
                filterTasks(status);
            });

            document.getElementById('mark-completed').addEventListener('click', (e) => {
                e.preventDefault();
                const selectedIds = getSelectedTaskIds();
                if (selectedIds.length === 0) {
                    alert('Please select at least one task.');
                    return;
                }
                showConfirmationModal('mark-completed', selectedIds);
                dropdownMenu.classList.add('hidden');
            });

            document.getElementById('mark-uncompleted').addEventListener('click', (e) => {
                e.preventDefault();
                const selectedIds = getSelectedTaskIds();
                if (selectedIds.length === 0) {
                    alert('Please select at least one task.');
                    return;
                }
                showConfirmationModal('mark-uncompleted', selectedIds);
                dropdownMenu.classList.add('hidden');
            });

            document.getElementById('delete-tasks-button').addEventListener('click', () => {
                const selectedIds = getSelectedTaskIds();
                if (selectedIds.length === 0) {
                    alert('Please select at least one task.');
                    return;
                }
                showConfirmationModal('delete-tasks', selectedIds);
            });

            function getSelectedTaskIds() {
                return Array.from(document.querySelectorAll('.task-checkbox:checked'))
                    .map(checkbox => checkbox.getAttribute('data-id'));
            }

            function showConfirmationModal(action, ids) {
                let modalId;
                let formAction;

                if (action === 'mark-completed' || action === 'mark-uncompleted') {
                    modalId = 'mark-unmark-modal';
                    formAction = action === 'mark-completed' ? "{{ route('task.multiple_complete') }}" :
                        "{{ route('task.multiple_uncomplete') }}";
                } else if (action === 'delete-tasks') {
                    modalId = 'delete-tasks-modal';
                    formAction = "{{ route('task.multiple_delete') }}";
                }

                const modal = document.getElementById(modalId);
                const form = modal.querySelector('form');
                form.action = formAction;
                form.querySelector('input[name="ids"]').value = JSON.stringify(ids);
                openModal(modalId);
            }

            updateButtonsState();
        });
    </script>

</x-layouts.app>
