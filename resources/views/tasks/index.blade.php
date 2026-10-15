
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Task Manager</h2>
            <p class="text-muted mb-0">Manage your daily tasks</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            + Add Task
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Please check the form and try again.
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}">
                <div class="form-row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="search"
                               class="form-control"
                               placeholder="Search by title..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="Pending"
                                {{ request('status') === 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="Completed"
                                {{ request('status') === 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <button class="btn btn-dark btn-block" type="submit">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">All Tasks</h5>

            @forelse($tasks as $task)
                <div class="border rounded p-3 mb-3
                    {{ $task->status === 'Completed' ? 'bg-light' : 'bg-white' }}">

                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="mb-2">
                            <h5 class="{{ $task->status === 'Completed' ? 'text-muted' : '' }}">
                                {{ $task->title }}
                            </h5>

                            @if($task->description)
                                <p class="mb-2">{{ $task->description }}</p>
                            @endif

                            <small class="text-muted">
                                Created: {{ $task->created_at->format('d M Y, h:i A') }}
                            </small>

                            <div class="mt-2">
                                @if($task->status === 'Completed')
                                    <span class="badge badge-success">Completed</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-start flex-wrap">
                            <form action="{{ route('tasks.toggleStatus', $task) }}"
                                  method="POST" class="mr-2 mb-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    {{ $task->status === 'Completed' ? 'Mark Pending' : 'Mark Completed' }}
                                </button>
                            </form>

                            <a href="{{ route('tasks.edit', $task) }}"
                               class="btn btn-sm btn-info mr-2 mb-2">
                                Edit
                            </a>

                            <button type="button"
                                    class="btn btn-sm btn-danger mb-2"
                                    data-toggle="modal"
                                    data-target="#deleteModal{{ $task->id }}">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteModal{{ $task->id }}"
                     tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Task</h5>
                                <button type="button" class="close"
                                        data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                Are you sure you want to delete
                                <strong>{{ $task->title }}</strong>?
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">
                                    Cancel
                                </button>

                                <form action="{{ route('tasks.destroy', $task) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Yes, Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <h5>No tasks found</h5>
                    <p class="text-muted">Create your first task to get started.</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        Add Task
                    </a>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $tasks->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</ht