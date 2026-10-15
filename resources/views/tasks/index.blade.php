<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youbloom - Task Manager</title>
    <!-- Perfect Production-Ready Bootstrap 4.6.2 CSS -->
    <link rel="stylesheet" href="https://jsdelivr.net" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
    <style>
        body { background-color: #f3f4f6 !important; font-family: sans-serif; padding: 30px 10px; margin: 0; }
        .main-card { background: white; border-radius: 12px; max-width: 1000px; margin: 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #e5e7eb; }
        h2 { color: #111827; text-align: center; margin-bottom: 30px; font-size: 28px; }
        h2 span { color: #0284c7; }
        .form-section { background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 30px; }
        .form-section h4 { margin-top: 0; margin-bottom: 15px; color: #374151; font-size: 18px; }
        .form-grid { display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; }
        .form-section label { font-size: 14px; font-weight: 600; color: #4b5563; }
        .input-field { padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 100%; box-sizing: border-box; }
        .btn-add { background-color: #10b981; color: white; border: none; padding: 11px 24px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; white-space: nowrap; }
        .search-section { display: flex; gap: 10px; margin-bottom: 20px; align-items: center; }
        .btn-search { background-color: #0284c7; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; }
        .task-table { width: 100%; border-collapse: collapse; text-align: left; margin-top: 10px; }
        .task-table th { background-color: #1f2937; color: white; padding: 12px; font-size: 13px; text-transform: uppercase; }
        .task-table td { padding: 15px 12px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; font-size: 15px; }
        .badge-pending { background-color: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 50px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .badge-completed { background-color: #d1fae5; color: #059669; padding: 4px 10px; border-radius: 50px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .btn-delete { background-color: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; cursor: pointer; }
        .btn-status { background-color: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; cursor: pointer; margin-right: 5px; }
        .alert-box { background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; border: 1px solid #a7f3d0; }
        .empty-row { text-align: center; padding: 40px !important; color: #6b7280; font-size: 16px; }
    </style>
</head>
<body>

<div class="main-card">
    <h2><span>youbloom</span> Task Manager</h2>

    @if(session('success'))
        <div class="alert-box">✓ {{ session('success') }}</div>
    @endif

    <!-- CREATION FORM WITH STABLE SECURITY INPUT -->
    <div class="form-section">
        <h4>Create New Task</h4>
        <form action="{{ route('tasks.store') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 1; min-width: 200px; display: flex; flex-direction: column; gap: 5px;">
                    <label>Task Title *</label>
                    <input type="text" name="title" class="input-field" placeholder="Enter task title..." required>
                </div>
                <div style="flex: 1.5; min-width: 200px; display: flex; flex-direction: column; gap: 5px;">
                    <label>Description (Optional)</label>
                    <input type="text" name="description" class="input-field" placeholder="Enter short details...">
                </div>
                <div style="flex: 0.5; min-width: 120px; display: flex; flex-direction: column; gap: 5px;">
                    <label>Initial Status *</label>
                    <select name="status" class="input-field">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn-add">Create Task</button>
            </div>
        </form>
    </div>

    <!-- SEARCH FILTERS -->
    <div class="search-section">
        <form action="{{ route('tasks.index') }}" method="GET" style="display: flex; gap: 10px; width: 100%;">
            <input type="text" name="search" class="input-field" style="max-width: 300px;" placeholder="Search tasks by title..." value="{{ $search }}">
            <button type="submit" class="btn-search">Search</button>
            @if($search)
                <a href="{{ route('tasks.index') }}" style="padding-top: 10px; color: #6b7280; text-decoration: none; font-size: 14px;">Clear Filter</a>
            @endif
        </form>
    </div>

    <!-- TASKS TABLE -->
    <table class="task-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Created Date</th>
                <th>Status</th>
                <th style="text-align: center; width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr style="{{ $task->status == 'Completed' ? 'background-color: #f9fafb; color: #9ca3af;' : '' }}">
                    <td>
                        @if($task->status == 'Completed') <del>{{ $task->title }}</del> @else <strong>{{ $task->title }}</strong> @endif
                    </td>
                    <td>{{ $task->description ?? 'No description' }}</td>
                    <td>{{ $task->created_at->format('d M, Y') }}</td>
                    <td>
                        <span class="{{ $task->status == 'Completed' ? 'badge-completed' : 'badge-pending' }}">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <!-- Sahi Toggle Link Jo Bina Token Block Ke Mark Pending Karega -->
                        <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" style="display: inline;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="title" value="{{ $task->title }}">
                            <input type="hidden" name="status" value="{{ $task->status == 'Pending' ? 'Completed' : 'Pending' }}">
                            <button type="submit" class="btn-status">
                                Mark {{ $task->status == 'Pending' ? 'Done' : 'Pending' }}
                            </button>
                        </form>

                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-row">No tasks found. Use the form above to add your first task!</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3 d-flex justify-content-center">
        {{ $tasks->appends(['search' => $search])->links('pagination::bootstrap-4') }}
    </div>
</div>

<script src="https://jquery.com"></script>
<script src="https://jsdelivr.net"></script>
</body>
</html>
