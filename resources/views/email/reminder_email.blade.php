<div>
    <h5>Hi Dear {{ $data['guest_name'] }},</h5>
    <h1>Event Reminder {{ $data['reminder_id'] }}</h1>
    <p>You have Event to attend on <strong style="color:blue;">[ {{ date('d, M, Y H:i:s', strtotime($data['event_time'])) }} ]</strong></p>
    <h3>{{ $data['event_name'] }} Event</h3>
    {{ $data['event_details'] }}
    <h1>Thank you</h1>
</div>
