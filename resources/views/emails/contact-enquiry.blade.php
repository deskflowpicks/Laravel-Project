
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Enquiry - Komdigital</title>
</head>
<body style="margin:0; padding:30px 15px; background:#f4f7fb; font-family:Arial,sans-serif; color:#263445;">

    <div style="max-width:650px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden;">

        <div style="background:#06152e; padding:30px; text-align:center;">
            <h1 style="margin:0; color:#ffffff; font-size:28px;">
                KOMDIGITAL
            </h1>
            <p style="margin:8px 0 0; color:#ffffff;">
                Build. Market. Grow.
            </p>
        </div>

        <div style="padding:30px;">
            <h2 style="color:#0b3761;">New Contact Enquiry</h2>

            <p>You have received a new message through the Komdigital website.</p>

            <h3>Visitor Details</h3>

            <p><strong>Name:</strong> {{ $contactMessage->name }}</p>
            <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
            <p><strong>Phone:</strong> {{ $contactMessage->phone ?: 'Not provided' }}</p>
            <p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>

            <h3>Message</h3>

            <div style="background:#f4f7fb; padding:20px; border-radius:6px; line-height:1.6;">
                {{ $contactMessage->message }}
            </div>

            <p style="margin-top:25px;">
                <a href="mailto:{{ $contactMessage->email }}"
                   style="display:inline-block; background:#0b3761; color:#ffffff; padding:12px 22px; text-decoration:none; border-radius:5px;">
                    Reply to Visitor
                </a>
            </p>
        </div>

        <div style="background:#06152e; padding:18px; text-align:center; color:#ffffff; font-size:12px;">
            Komdigital | Build. Market. Grow.
            <br>
            This is an automated notification from your website.
        </div>

    </div>

</body>
</html>
