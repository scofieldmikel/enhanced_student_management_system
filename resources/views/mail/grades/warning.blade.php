<x-mail::message>
# Dear {{ $grade->student->parent->user->name }},

I hope this message finds you well.

We are writing to inform you that your child, {{ $grade->student->user->name }}, recently completed the {{ $grade->subject->name }} as part of our ongoing academic assessment process within the School.

Following the evaluation, {{ $grade->student->user->name }} scored {{ $grade->score }}, which is below the expected performance threshold for this exam. While we understand that occasional academic setbacks happen, we believe this is an opportunity for timely support and intervention.

We kindly encourage you to review the performance summary on the parent portal. Our team of educators is available to discuss the results and develop a support plan tailored to help {{ $grade->student->user->name }} improve in the upcoming term.

If you have any questions or would like to schedule a meeting with his/her subject teacher or academic advisor, please do not hesitate to reach out.

Thank you for your continued support.

Warm regards,<br />
Zainab Osho <br/>
Academic Coordinator <br/>
[School Name]
</x-mail::message>
