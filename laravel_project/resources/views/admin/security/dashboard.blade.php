@extends('layouts.admin')

@section('title', 'Security Dashboard')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Security Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Security</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Security Statistics -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stats['total_users'] }}</h3>
                            <p>Total Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stats['active_sessions'] }}</h3>
                            <p>Active Sessions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $stats['locked_users'] }}</h3>
                            <p>Locked Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stats['critical_logs'] }}</h3>
                            <p>Critical Events</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Security Events -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shield-alt"></i>
                                Recent Security Events
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Severity</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentEvents as $event)
                                        <tr>
                                            <td>{{ $event->user ? $event->user->name : 'Guest' }}</td>
                                            <td>{{ $event->action }}</td>
                                            <td>
                                                <span class="badge badge-{{ $event->severity_color }}">
                                                    {{ ucfirst($event->severity) }}
                                                </span>
                                            </td>
                                            <td>{{ $event->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No recent security events</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.security.audit-logs') }}" class="btn btn-sm btn-primary">
                                View All Events
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Sessions -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-desktop"></i>
                                Active Sessions
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Device</th>
                                            <th>Last Activity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($activeSessions as $session)
                                        <tr>
                                            <td>{{ $session->user->name }}</td>
                                            <td>
                                                <i class="fas fa-{{ $session->device_type === 'mobile' ? 'mobile-alt' : ($session->device_type === 'tablet' ? 'tablet-alt' : 'desktop') }}"></i>
                                                {{ ucfirst($session->device_type) }}
                                            </td>
                                            <td>{{ $session->last_activity->diffForHumans() }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" onclick="terminateSession({{ $session->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No active sessions</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.security.sessions') }}" class="btn btn-sm btn-primary">
                                View All Sessions
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tools"></i>
                                Security Actions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('admin.security.audit-logs') }}" class="btn btn-block btn-info">
                                        <i class="fas fa-list"></i> Audit Logs
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.security.sessions') }}" class="btn btn-block btn-warning">
                                        <i class="fas fa-desktop"></i> User Sessions
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-block btn-success" onclick="exportAuditLogs()">
                                        <i class="fas fa-download"></i> Export Logs
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-block btn-danger" onclick="cleanExpiredSessions()">
                                        <i class="fas fa-broom"></i> Clean Sessions
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Terminate Session Modal -->
<div class="modal fade" id="terminateSessionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terminate Session</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to terminate this session?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmTerminate">Terminate</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let sessionIdToTerminate = null;

function terminateSession(sessionId) {
    sessionIdToTerminate = sessionId;
    $('#terminateSessionModal').modal('show');
}

$('#confirmTerminate').click(function() {
    if (sessionIdToTerminate) {
        $.post(`/admin/security/sessions/${sessionIdToTerminate}/terminate`, {
            _token: '{{ csrf_token() }}'
        })
        .done(function() {
            location.reload();
        })
        .fail(function() {
            alert('Failed to terminate session');
        });
    }
    $('#terminateSessionModal').modal('hide');
});

function exportAuditLogs() {
    window.location.href = '{{ route("admin.security.export-audit-logs") }}';
}

function cleanExpiredSessions() {
    if (confirm('Are you sure you want to clean expired sessions?')) {
        $.post('{{ route("admin.security.clean-sessions") }}', {
            _token: '{{ csrf_token() }}'
        })
        .done(function() {
            location.reload();
        })
        .fail(function() {
            alert('Failed to clean sessions');
        });
    }
}
</script>
@endpush 