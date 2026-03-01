@extends('admin.layouts.app')
@section('page_title', 'Customers')
@section('content')
<div class="admin-card">
    <h3><i class="fas fa-users"></i> Customers</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
                <th>Orders</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td><strong>{{ $customer->name }}</strong></td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('M d, Y') }}</td>
                    <td>{{ $customer->orders_count ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;padding:40px;color:#6d7175;">No customers yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $customers->links() }}</div>
</div>
@endsection
