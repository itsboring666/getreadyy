@extends('admin.layout')

@section('content')
<div class="mb-8" data-aos="fade-down">
    <h1 class="text-3xl font-bold text-gray-800">✉️ Contact Messages</h1>
    <p class="text-gray-500 mt-1">View and manage messages sent from the Contact Us form.</p>
</div>

<!-- Messages List Table -->
<div class="overflow-x-auto" data-aos="fade-up" data-aos-delay="100">
    <table class="min-w-full bg-white rounded-xl shadow">
        <thead class="bg-[#536451] text-[#f3e9d5] uppercase text-sm">
            <tr>
                <th class="py-3 px-6 text-left">Date</th>
                <th class="py-3 px-6 text-left">Sender</th>
                <th class="py-3 px-6 text-left">Subject & Message</th>
                <th class="py-3 px-6 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @forelse ($messages as $index => $msg)
            <tr class="border-b hover:bg-gray-50 {{ $msg->is_read ? 'opacity-75' : 'font-semibold bg-blue-50' }}" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}" id="msg-row-{{ $msg->id }}">
                <td class="py-3 px-6 whitespace-nowrap">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                <td class="py-3 px-6">
                    <div>{{ $msg->name }}</div>
                    <div class="text-xs text-gray-500"><a href="mailto:{{ $msg->email }}" class="hover:underline">{{ $msg->email }}</a></div>
                    @if($msg->phone)
                    <div class="text-xs text-gray-500"><a href="tel:{{ $msg->phone }}" class="hover:underline">{{ $msg->phone }}</a></div>
                    @endif
                </td>
                <td class="py-3 px-6">
                    <div class="text-md text-[#536451]">{{ $msg->subject }}</div>
                    <div class="text-sm mt-1 max-w-lg truncate">{{ $msg->message }}</div>
                    <button onclick="viewMessage('{{ addslashes($msg->subject) }}', '{{ addslashes($msg->name) }}', '{{ addslashes($msg->email) }}', '{{ addslashes($msg->phone) }}', '{{ addslashes($msg->message) }}', {{ $msg->id }})" class="text-blue-500 hover:underline text-xs mt-2">Read Full Message</button>
                </td>
                <td class="py-3 px-6 text-right whitespace-nowrap">
                    <form action="{{ route('admin.contact-messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr data-aos="fade-up">
                <td colspan="4" class="text-center text-gray-500 py-8">No contact messages received yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Message View Modal -->
<div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg w-11/12 max-w-2xl overflow-hidden transform transition-all">
        <div class="bg-[#536451] px-6 py-4 flex justify-between items-center text-[#f3e9d5]">
            <h3 class="text-xl font-bold truncate" id="modalSubject">Message Subject</h3>
            <button onclick="closeModal()" class="text-[#f3e9d5] hover:text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6 border-b pb-4 text-sm">
                <div>
                    <span class="text-gray-500 font-semibold block uppercase text-xs">From</span>
                    <span id="modalName" class="font-medium text-gray-800"></span>
                </div>
                <div>
                    <span class="text-gray-500 font-semibold block uppercase text-xs">Email</span>
                    <a href="#" id="modalEmail" class="text-blue-600 hover:underline"></a>
                </div>
                <div>
                    <span class="text-gray-500 font-semibold block uppercase text-xs">Phone</span>
                    <a href="#" id="modalPhone" class="text-blue-600 hover:underline"></a>
                </div>
            </div>
            <div class="text-gray-800 whitespace-pre-wrap leading-relaxed max-h-96 overflow-y-auto" id="modalMessageBody">
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex justify-end">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors">Close</button>
            <a href="#" id="modalReplyBtn" class="ml-3 px-4 py-2 bg-[#536451] text-white rounded hover:bg-[#404f3f] transition-colors">Reply via Email</a>
        </div>
    </div>
</div>

<script>
    function viewMessage(subject, name, email, phone, body, id) {
        document.getElementById('modalSubject').innerText = subject;
        document.getElementById('modalName').innerText = name;
        
        const emailLink = document.getElementById('modalEmail');
        emailLink.innerText = email;
        emailLink.href = 'mailto:' + email;
        
        const phoneLink = document.getElementById('modalPhone');
        phoneLink.innerText = phone || 'Not provided';
        if(phone) {
            phoneLink.href = 'tel:' + phone;
        } else {
            phoneLink.removeAttribute('href');
        }
        
        document.getElementById('modalMessageBody').innerText = body;
        
        document.getElementById('modalReplyBtn').href = 'mailto:' + email + '?subject=Re: ' + encodeURIComponent(subject);
        
        document.getElementById('messageModal').classList.remove('hidden');
        
        // Mark as read via AJAX
        const row = document.getElementById('msg-row-' + id);
        if (row && row.classList.contains('font-semibold')) {
            fetch(`{{ url('admin/contact-messages') }}/${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(res => {
                if(res.ok) {
                    row.classList.remove('font-semibold', 'bg-blue-50');
                    row.classList.add('opacity-75');
                }
            });
        }
    }

    function closeModal() {
        document.getElementById('messageModal').classList.add('hidden');
    }
</script>
@endsection
