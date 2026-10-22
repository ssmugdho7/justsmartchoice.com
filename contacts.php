<?php
/* =========================================================
   SMART CHOICE CONTRACTORS USA
   CONTACT PAGE
   ========================================================= */

$formMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once __DIR__ . '/includes/contact-recaptcha.php';
    if (!sc_contact_recaptcha_valid($_POST['g-recaptcha-response'] ?? null)) {
        http_response_code(422);
        echo 'Please complete the security check and submit the contact form again.';
        exit;
    }

    $name    = trim($_POST['name'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    /* =====================================================
       EMAIL CONFIGURATION
       ===================================================== */

    $to = 'lead@justsmartchoice.com,sales@justsmartchoice.com,admin@justsmartchoice.com,haroldcabrerausa@gmail.com';

    $subject = 'New Lead from the website.';

    /* =====================================================
       FILE UPLOAD SETTINGS
       ===================================================== */

    $maxFileSize  = 10 * 1024 * 1024; // 10 MB each
    $maxTotalSize = 20 * 1024 * 1024; // 20 MB total

    $allowedExtensions = [
        'pdf',
        'jpg',
        'jpeg',
        'png',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'txt',
        'dwg',
        'dxf'
    ];

    $uploadedAttachments = [];
    $uploadErrors = [];
    $totalUploadSize = 0;

    /* =====================================================
       VALIDATE FORM
       ===================================================== */

    if (
        $name !== '' &&
        $phone !== '' &&
        filter_var($email, FILTER_VALIDATE_EMAIL) &&
        $message !== ''
    ) {

        /* =================================================
           PROCESS PROJECT DOCUMENTS
           ================================================= */

        if (
            isset($_FILES['project_documents']) &&
            isset($_FILES['project_documents']['name']) &&
            is_array($_FILES['project_documents']['name'])
        ) {

            $fileCount = count($_FILES['project_documents']['name']);

            for ($i = 0; $i < $fileCount; $i++) {

                $originalName = $_FILES['project_documents']['name'][$i] ?? '';
                $tmpName      = $_FILES['project_documents']['tmp_name'][$i] ?? '';
                $fileSize     = (int)($_FILES['project_documents']['size'][$i] ?? 0);
                $fileError    = (int)($_FILES['project_documents']['error'][$i] ?? UPLOAD_ERR_NO_FILE);

                /* Ignore empty upload slots */
                if ($fileError === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                if ($fileError !== UPLOAD_ERR_OK) {

                    switch ($fileError) {

                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            $uploadErrors[] = $originalName . ' exceeds the server upload size limit.';
                            break;

                        case UPLOAD_ERR_PARTIAL:
                            $uploadErrors[] = $originalName . ' was only partially uploaded.';
                            break;

                        case UPLOAD_ERR_NO_TMP_DIR:
                            $uploadErrors[] = 'The server temporary upload folder is unavailable.';
                            break;

                        case UPLOAD_ERR_CANT_WRITE:
                            $uploadErrors[] = 'The server could not save ' . $originalName . '.';
                            break;

                        default:
                            $uploadErrors[] = 'There was a problem uploading ' . $originalName . '.';
                            break;
                    }

                    continue;
                }

                /* =================================================
                   CLEAN FILE NAME
                   ================================================= */

                $safeName = basename($originalName);

                $safeName = preg_replace(
                    '/[^A-Za-z0-9._()\- ]/',
                    '_',
                    $safeName
                );

                if ($safeName === '' || $safeName === '.' || $safeName === '..') {
                    $safeName = 'project-document-' . ($i + 1);
                }

                /* =================================================
                   CHECK EXTENSION
                   ================================================= */

                $extension = strtolower(
                    pathinfo($safeName, PATHINFO_EXTENSION)
                );

                if (!in_array($extension, $allowedExtensions, true)) {

                    $uploadErrors[] =
                        $safeName .
                        ' is not an accepted file type.';

                    continue;
                }

                /* =================================================
                   CHECK INDIVIDUAL FILE SIZE
                   ================================================= */

                if ($fileSize <= 0) {

                    $uploadErrors[] =
                        $safeName .
                        ' appears to be empty.';

                    continue;
                }

                if ($fileSize > $maxFileSize) {

                    $uploadErrors[] =
                        $safeName .
                        ' is larger than the 10 MB per-file limit.';

                    continue;
                }

                /* =================================================
                   CHECK TOTAL SIZE
                   ================================================= */

                if (($totalUploadSize + $fileSize) > $maxTotalSize) {

                    $uploadErrors[] =
                        'The combined attachments exceed the 20 MB total upload limit.';

                    break;
                }

                if (!is_uploaded_file($tmpName)) {

                    $uploadErrors[] =
                        $safeName .
                        ' could not be validated as an uploaded file.';

                    continue;
                }

                /* =================================================
                   DETECT MIME TYPE
                   ================================================= */

                $mimeType = 'application/octet-stream';

                if (
                    function_exists('finfo_open') &&
                    function_exists('finfo_file')
                ) {

                    $finfo = finfo_open(FILEINFO_MIME_TYPE);

                    if ($finfo) {

                        $detectedMime = finfo_file(
                            $finfo,
                            $tmpName
                        );

                        finfo_close($finfo);

                        if (!empty($detectedMime)) {
                            $mimeType = $detectedMime;
                        }
                    }
                }

                $uploadedAttachments[] = [
                    'name' => $safeName,
                    'tmp_name' => $tmpName,
                    'size' => $fileSize,
                    'type' => $mimeType
                ];

                $totalUploadSize += $fileSize;
            }
        }

        /* =================================================
           STOP IF AN UPLOAD FAILED
           ================================================= */

        if (!empty($uploadErrors)) {

            $formMessage =
                '<div class="alert alert-danger">' .
                '<strong>Your message was not sent because one or more documents could not be uploaded.</strong><br>' .
                implode('<br>', array_map('htmlspecialchars', $uploadErrors)) .
                '</div>';

        } else {

            /* =================================================
               EMAIL BODY
               ================================================= */

            $body = "Website Lead Received\n\n";

            $body .= "Name: {$name}\n";
            $body .= "Phone: {$phone}\n";
            $body .= "Email: {$email}\n\n";

            $body .= "Message:\n";
            $body .= "{$message}\n\n";

            if (!empty($uploadedAttachments)) {

                $body .= "Project Documents Attached:\n";

                foreach ($uploadedAttachments as $attachment) {

                    $body .=
                        "- " .
                        $attachment['name'] .
                        "\n";
                }

                $body .= "\n";
            } else {

                $body .= "Project Documents Attached: None\n\n";
            }

            /* =================================================
               BASIC EMAIL HEADERS
               ================================================= */

            $cleanReplyEmail = str_replace(
                ["\r", "\n"],
                '',
                $email
            );

            /* =================================================
               SEND EMAIL WITHOUT ATTACHMENTS
               ================================================= */

            if (empty($uploadedAttachments)) {

                $headers  = "From: Smart Choice Website <noreply@justsmartchoice.com>\r\n";
                $headers .= "Reply-To: {$cleanReplyEmail}\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                $mailSent = mail(
                    $to,
                    $subject,
                    $body,
                    $headers
                );

            } else {

                /* =================================================
                   SEND MULTIPART EMAIL WITH ATTACHMENTS
                   ================================================= */

                $boundary =
                    '=_SmartChoice_' .
                    md5(uniqid((string)microtime(true), true));

                $headers  = "From: Smart Choice Website <noreply@justsmartchoice.com>\r\n";
                $headers .= "Reply-To: {$cleanReplyEmail}\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

                $emailBody = '';

                /* =================================================
                   TEXT PORTION
                   ================================================= */

                $emailBody .= "--{$boundary}\r\n";
                $emailBody .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $emailBody .= "Content-Transfer-Encoding: 8bit\r\n\r\n";

                $emailBody .= $body;
                $emailBody .= "\r\n";

                /* =================================================
                   ATTACHMENT PORTIONS
                   ================================================= */

                foreach ($uploadedAttachments as $attachment) {

                    $fileContents = @file_get_contents(
                        $attachment['tmp_name']
                    );

                    if ($fileContents === false) {
                        continue;
                    }

                    $encodedFile = chunk_split(
                        base64_encode($fileContents)
                    );

                    $attachmentName = str_replace(
                        ['"', "\r", "\n"],
                        '',
                        $attachment['name']
                    );

                    $attachmentType = str_replace(
                        ["\r", "\n"],
                        '',
                        $attachment['type']
                    );

                    $emailBody .= "--{$boundary}\r\n";

                    $emailBody .=
                        "Content-Type: {$attachmentType}; name=\"{$attachmentName}\"\r\n";

                    $emailBody .=
                        "Content-Disposition: attachment; filename=\"{$attachmentName}\"\r\n";

                    $emailBody .=
                        "Content-Transfer-Encoding: base64\r\n\r\n";

                    $emailBody .= $encodedFile;
                    $emailBody .= "\r\n";
                }

                $emailBody .= "--{$boundary}--\r\n";

                $mailSent = mail(
                    $to,
                    $subject,
                    $emailBody,
                    $headers
                );
            }

            /* =================================================
               RESULT
               ================================================= */

            if ($mailSent) {

                $attachmentMessage = '';

                if (!empty($uploadedAttachments)) {

                    $attachmentCount =
                        count($uploadedAttachments);

                    $attachmentMessage =
                        ' Your ' .
                        $attachmentCount .
                        ($attachmentCount === 1 ? ' document was' : ' documents were') .
                        ' attached successfully.';
                }

                $formMessage =
                    '<div class="alert alert-success">' .
                    'Thank you. Your message was sent successfully.' .
                    $attachmentMessage .
                    ' Our team will contact you within 8 to 24 business hours.' .
                    '</div>';

            } else {

                $formMessage =
                    '<div class="alert alert-danger">' .
                    'There was a problem sending your message or attachments. ' .
                    'Please call us directly at (727) 755-3786.' .
                    '</div>';
            }
        }

    } else {

        $formMessage =
            '<div class="alert alert-warning">' .
            'Please complete all required fields with valid information.' .
            '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-CLX99EJXW2"></script>

<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}

gtag('js', new Date());

gtag(
    'config',
    'G-CLX99EJXW2'
);
</script>

<?php include __DIR__ . '/includes/cookie-consent-head.php'; ?>

<meta charset="utf-8">

<meta
    http-equiv="X-UA-Compatible"
    content="IE=edge"
>

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, height=device-height"
>

<script
    src="https://analytics.ahrefs.com/analytics.js"
    data-key="9gWoEoaoQSTW3cXLEcA/Qg"
    async>
</script>

<script
    src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js"
    async>
</script>

<title>
    Contact Just Smart Choice Construction USA | Tampa Bay Contractor
</title>

<link
    rel="canonical"
    href="https://justsmartchoice.com/contacts.php"
>

<meta
    name="description"
    content="Contact Smart Choice Contractors USA for construction, remodeling, roofing, electrical, plumbing and project planning across Tampa Bay, Florida."
>

<meta
    name="keywords"
    content="Contact Contractor Tampa Bay, Construction Company Contact Florida, Remodeling Contractor Tampa, Just Smart Choice Contact, General Contractor Tampa Bay"
>

<meta
    name="author"
    content="Just Smart Choice Construction USA"
>

<meta
    name="robots"
    content="index, follow"
>

<meta
    property="og:title"
    content="Contact Just Smart Choice Construction USA"
>

<meta
    property="og:description"
    content="Contact our Tampa Bay construction and remodeling team for residential and commercial construction services."
>

<meta
    property="og:url"
    content="https://justsmartchoice.com/contacts.php"
>

<meta
    property="og:type"
    content="website"
>

<meta
    property="og:site_name"
    content="Just Smart Choice Construction USA"
>

<meta
    property="og:image"
    content="https://justsmartchoice.com/images/fg-image.png"
>

<meta
    name="twitter:card"
    content="summary_large_image"
>

<meta
    name="twitter:title"
    content="Contact Just Smart Choice Construction USA"
>

<meta
    name="twitter:description"
    content="Contact a Tampa Bay construction and remodeling company for your next project."
>

<meta
    name="twitter:image"
    content="https://justsmartchoice.com/images/fg-image.png"
>


<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "@id": "https://justsmartchoice.com/contacts.php#contactpage",
  "url": "https://justsmartchoice.com/contacts.php",
  "name": "Contact Just Smart Choice Construction USA",
  "description": "Contact page for Just Smart Choice Construction USA, a Tampa Bay construction and remodeling company.",
  "mainEntity": {
    "@type": "GeneralContractor",
    "@id": "https://justsmartchoice.com/#organization",
    "name": "Just Smart Choice Construction USA",
    "url": "https://justsmartchoice.com/",
    "telephone": "+1-727-755-3786",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "1663 US Highway 41",
      "addressLocality": "Spring Hill",
      "addressRegion": "FL",
      "postalCode": "34610",
      "addressCountry": "US"
    }
  }
}
</script>


<link
    rel="icon"
    href="images/favicon.ico"
    type="image/x-icon"
>

<link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900"
>

<link
    rel="stylesheet"
    href="css/style.css"
>

<link
    rel="stylesheet"
    href="css/custom.css?v=60"
>


<style>

/* =========================================================
   SMART CHOICE CONTACT PAGE
   ========================================================= */

:root {

    --sc-green: #169179;
    --sc-green-dark: #0e6f5b;

    --sc-blue: #0057b8;
    --sc-blue-dark: #003f88;

    --sc-orange: #f28c28;
    --sc-orange-dark: #d96f0b;

    --sc-black: #111827;
    --sc-gray: #4b5563;

    --sc-light: #f4f7f8;
    --sc-border: #dce5e8;

    --sc-white: #ffffff;
}


/* =========================================================
   CONTACT OVERVIEW
   ========================================================= */

.smart-contact-overview {

    background:
        linear-gradient(
            135deg,
            #eef8f5 0%,
            #f4f8fd 55%,
            #fff6eb 100%
        );
}


.smart-overview-equal-row {

    display: flex;
    flex-wrap: wrap;
}


.smart-overview-equal-row > [class*="col-"] {

    display: flex;
}


.smart-overview-card {

    width: 100%;

    padding: 28px 24px;

    background: var(--sc-white);

    border: 1px solid var(--sc-border);
    border-top: 5px solid var(--sc-green);

    border-radius: 10px;

    box-shadow:
        0 11px 28px rgba(17, 24, 39, 0.10);
}


.smart-overview-equal-row > div:nth-child(2)
.smart-overview-card {

    border-top-color:
        var(--sc-orange);
}


.smart-overview-equal-row > div:nth-child(3)
.smart-overview-card {

    border-top-color:
        var(--sc-blue);
}


.smart-overview-card h2 {

    color:
        var(--sc-black);

    font-size:
        22px;
}


.smart-overview-card p,
.smart-overview-card li {

    color:
        var(--sc-gray);
}


.smart-overview-icon {

    margin-bottom:
        14px;

    font-size:
        35px;
}


.smart-crm-access-box {

    border-radius:
        6px !important;
}


/* =========================================================
   MAP SECTION
   ========================================================= */

.smart-map-section {

    position:
        relative;

    overflow:
        hidden;

    background:
        #e7edef;
}


.smart-map-wrap {

    position:
        relative;

    min-height:
        520px;
}


.smart-map-frame {

    display:
        block;

    width:
        100%;

    height:
        520px;

    border:
        0;

    filter:
        saturate(0.96)
        contrast(1.02);
}


/* =========================================================
   IMPORTANT:
   NO MANUAL MAP PIN

   The old manually-positioned CSS marker was removed.

   The Google Maps iframe now controls the true location
   marker based directly on the Spring Hill office address.
   ========================================================= */


/* =========================================================
   MAP INFORMATION CARD
   ========================================================= */

.smart-map-card-wrap {

    position:
        absolute;

    z-index:
        2;

    top:
        50%;

    left:
        max(
            24px,
            calc((100% - 1170px) / 2)
        );

    width:
        min(
            390px,
            calc(100% - 48px)
        );

    transform:
        translateY(-50%);
}


.smart-map-card {

    padding:
        30px;

    background:
        rgba(255, 255, 255, 0.97);

    border:
        1px solid var(--sc-border);

    border-top:
        5px solid var(--sc-orange);

    border-radius:
        10px;

    box-shadow:
        0 18px 45px
        rgba(17, 24, 39, 0.22);

    backdrop-filter:
        blur(8px);
}


.smart-map-eyebrow {

    display:
        inline-block;

    margin-bottom:
        8px;

    color:
        var(--sc-green-dark);

    font-size:
        12px;

    font-weight:
        800;

    letter-spacing:
        0.08em;

    text-transform:
        uppercase;
}


.smart-map-card h2 {

    margin:
        0 0 12px;

    color:
        var(--sc-black);

    font-size:
        28px;

    line-height:
        1.25;
}


.smart-map-address {

    margin-bottom:
        8px;

    color:
        var(--sc-black);

    font-size:
        16px;

    line-height:
        1.6;
}


.smart-map-card p {

    color:
        var(--sc-gray);

    line-height:
        1.65;
}


.smart-map-actions {

    display:
        grid;

    grid-template-columns:
        repeat(
            2,
            minmax(0, 1fr)
        );

    gap:
        10px;

    margin-top:
        20px;
}


.smart-map-button {

    display:
        inline-flex;

    min-height:
        44px;

    align-items:
        center;

    justify-content:
        center;

    gap:
        9px;

    padding:
        10px 12px;

    border:
        1px solid
        var(--sc-green-dark);

    border-radius:
        6px;

    background:
        var(--sc-green);

    color:
        var(--sc-white) !important;

    font-size:
        13px;

    font-weight:
        800;

    line-height:
        1;

    text-align:
        center;

    text-decoration:
        none;

    white-space:
        nowrap;
}


.smart-map-button--blue {

    border-color:
        var(--sc-blue-dark);

    background:
        var(--sc-blue);
}


.smart-map-button--orange {

    border-color:
        var(--sc-orange-dark);

    background:
        var(--sc-orange);
}


.smart-map-button--wide {

    grid-column:
        1 / -1;
}


.smart-map-button:hover,
.smart-map-button:focus {

    background:
        var(--sc-green-dark);

    color:
        var(--sc-white);
}


.smart-map-button--blue:hover,
.smart-map-button--blue:focus {

    background:
        var(--sc-blue-dark);
}


.smart-map-button--orange:hover,
.smart-map-button--orange:focus {

    background:
        var(--sc-orange-dark);
}


/* =========================================================
   CONTACT FORM
   ========================================================= */

.smart-contact-form-section h1 {

    margin-bottom:
        25px;

    color:
        var(--sc-black);

    text-align:
        center;
}


.smart-contact-form-section form {

    padding:
        30px;

    background:
        var(--sc-white);

    border:
        1px solid var(--sc-border);

    border-top:
        4px solid var(--sc-green);

    border-radius:
        10px;

    box-shadow:
        0 10px 28px
        rgba(17, 24, 39, 0.09);
}


/* =========================================================
   DOCUMENT UPLOAD AREA
   ========================================================= */

.smart-document-upload {

    margin-top:
        5px;

    padding:
        22px;

    background:
        #f7faf9;

    border:
        2px dashed
        #b9d6cf;

    border-radius:
        8px;
}


.smart-document-upload-title {

    display:
        block;

    margin-bottom:
        7px;

    color:
        var(--sc-black);

    font-size:
        16px;

    font-weight:
        800;
}


.smart-document-upload-description {

    display:
        block;

    margin-bottom:
        14px;

    color:
        var(--sc-gray);

    font-size:
        13px;

    line-height:
        1.55;
}


.smart-document-upload input[type="file"] {

    display:
        block;

    width:
        100%;

    min-height:
        45px;

    padding:
        8px;

    background:
        #ffffff;

    border:
        1px solid
        var(--sc-border);

    border-radius:
        6px;

    color:
        var(--sc-black);

    cursor:
        pointer;
}


.smart-document-upload small {

    display:
        block;

    margin-top:
        9px;

    color:
        var(--sc-gray);

    font-size:
        11px;

    line-height:
        1.5;
}


/* =========================================================
   SUBMIT BUTTON
   ========================================================= */

.smart-contact-submit-wrap {

    margin-top:
        18px;

    text-align:
        center;
}


.smart-contact-submit {

    display:
        inline-flex;

    width:
        auto !important;

    min-width:
        125px;

    min-height:
        42px;

    align-items:
        center;

    justify-content:
        center;

    padding:
        9px 22px !important;

    border:
        1px solid
        var(--sc-green-dark) !important;

    border-radius:
        6px !important;

    background:
        var(--sc-green) !important;

    color:
        var(--sc-white) !important;

    font-size:
        14px !important;

    font-weight:
        800;

    line-height:
        1 !important;
}


.smart-contact-submit:hover,
.smart-contact-submit:focus {

    background:
        var(--sc-green-dark) !important;
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767px) {

    .smart-map-wrap {

        display:
            flex;

        min-height:
            0;

        flex-direction:
            column;
    }


    .smart-map-frame {

        height:
            360px;
    }


    .smart-map-card-wrap {

        position:
            relative;

        top:
            auto;

        left:
            auto;

        width:
            100%;

        padding:
            18px;

        transform:
            none;
    }


    .smart-map-card {

        padding:
            24px 20px;
    }


    .smart-map-actions {

        grid-template-columns:
            1fr;
    }


    .smart-map-button--wide {

        grid-column:
            auto;
    }


    .smart-contact-form-section form {

        padding:
            24px 18px;
    }


    .smart-document-upload {

        padding:
            18px 15px;
    }
}

</style>

</head>


<body>


<?php include __DIR__ . '/includes/cookie-consent.php'; ?>

<?php include __DIR__ . '/sections-library/header.php'; ?>


<!-- =========================================================
     CONTACT OVERVIEW
     ========================================================= -->

<section class="section-sm smart-contact-overview">

    <div class="container">

        <div class="row row-30 smart-overview-equal-row">


            <!-- OUR GOAL -->

            <div class="col-md-6 col-lg-4">

                <article class="smart-overview-card">

                    <div class="smart-overview-icon">
                        🏗️
                    </div>

                    <h2 class="text-uppercase">
                        Our Goal
                    </h2>

                    <p class="smart-overview-lead">

                        Professional construction support for Tampa Bay homeowners, property investors, and business owners.

                    </p>

                    <ol class="smart-overview-list">

                        <li>
                            Deliver dependable construction, remodeling, electrical, plumbing, roofing, and property improvement services.
                        </li>

                        <li>
                            Provide clear communication, organized project coordination, and quality workmanship from start to finish.
                        </li>

                        <li>
                            Build long-term customer relationships by becoming your preferred contractor in Florida.
                        </li>

                    </ol>

                </article>

            </div>


            <!-- WHO TO CONTACT -->

            <div class="col-md-6 col-lg-4">

                <article class="smart-overview-card">

                    <div class="smart-overview-icon">
                        📞
                    </div>

                    <h2 class="text-uppercase">
                        Who to Contact?
                    </h2>

                    <p class="smart-overview-lead">

                        Talk to the right department for faster project support.

                    </p>

                    <p>

                        Whether you need an estimate, construction drawings, permit support, project management, or field coordination, our team can route your request to the proper department.

                    </p>

                    <ul class="smart-overview-link-list">

                        <li>
                            <a href="contacts.php">
                                Project Management
                            </a>
                        </li>

                        <li>
                            <a href="contacts.php">
                                Design, Drawings &amp; Engineering
                            </a>
                        </li>

                        <li>
                            <a href="contacts.php">
                                Construction &amp; Site Operations
                            </a>
                        </li>

                        <li>
                            <a href="contacts.php">
                                Customer Support &amp; Service Requests
                            </a>
                        </li>

                    </ul>

                </article>

            </div>


            <!-- CLIENT RESOURCES -->

            <div class="col-md-6 col-lg-4">

                <article class="smart-overview-card smart-resource-card">

                    <div class="smart-overview-icon">
                        🗂️
                    </div>

                    <h2 class="text-uppercase">
                        Client Resources
                    </h2>

                    <p class="smart-overview-lead">

                        Access your construction project information online.

                    </p>

                    <p>

                        Existing clients can use our secure CRM portal to review project information, appointments, documents, estimates, invoices, and service updates.

                    </p>

                    <a
                        class="smart-crm-access-box"
                        href="https://crm.justsmartchoice.com/authentication/login"
                        target="_blank"
                        rel="noopener noreferrer"
                    >

                        <span class="smart-crm-icon">
                            🔐
                        </span>

                        <span>

                            <strong>
                                Client CRM Access
                            </strong>

                            <small>
                                Open project files and customer portal
                            </small>

                        </span>

                    </a>

                </article>

            </div>


        </div>

    </div>

</section>


<!-- =========================================================
     SMART CHOICE OFFICE MAP
     ========================================================= -->

<section
    class="smart-map-section"
    aria-labelledby="smart-map-title"
>

    <div class="smart-map-wrap">


        <!--
        Google Maps is now centered directly on the
        Smart Choice Contractors USA Spring Hill office.

        The old artificial HTML/CSS map pin has been removed.
        -->

        <iframe
            class="smart-map-frame"
            title="Google Map showing Smart Choice Contractors USA at 1663 US Highway 41, Spring Hill, Florida 34610"
            src="https://www.google.com/maps?q=Smart+Choice+Contractors+USA%2C+1663+US+Highway+41%2C+Spring+Hill%2C+FL+34610&amp;hl=en&amp;z=15&amp;output=embed"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>


        <!-- MAP INFORMATION CARD -->

        <div class="smart-map-card-wrap">

            <div class="smart-map-card">

                <span class="smart-map-eyebrow">

                    Visit Smart Choice Contractors USA

                </span>


                <h2 id="smart-map-title">

                    Find Our Location

                </h2>


                <address class="smart-map-address">

                    <strong>
                        Smart Choice Contractors USA
                    </strong>

                    <br>

                    1663 US Highway 41

                    <br>

                    Spring Hill, FL 34610

                </address>


                <p>

                    Use Google Maps for live directions, estimated travel time, traffic information, and route options.

                </p>


                <div class="smart-map-actions">


                    <!-- GET DIRECTIONS -->

                    <a
                        class="smart-map-button"
                        href="https://www.google.com/maps/dir/?api=1&amp;destination=1663+US+Highway+41%2C+Spring+Hill%2C+FL+34610"
                        target="_blank"
                        rel="noopener noreferrer"
                    >

                        <span
                            class="fa fa-location-arrow"
                            aria-hidden="true"
                        ></span>

                        Get Directions

                    </a>


                    <!-- OPEN GOOGLE MAPS -->

                    <a
                        class="smart-map-button smart-map-button--blue"
                        href="https://www.google.com/maps/search/?api=1&amp;query=Smart+Choice+Contractors+USA%2C+1663+US+Highway+41%2C+Spring+Hill%2C+FL+34610"
                        target="_blank"
                        rel="noopener noreferrer"
                    >

                        <span
                            class="fa fa-map-marker"
                            aria-hidden="true"
                        ></span>

                        Open Google Maps

                    </a>


                    <!-- CALL -->

                    <a
                        class="smart-map-button smart-map-button--orange smart-map-button--wide"
                        href="tel:+17277553786"
                    >

                        <span
                            class="fa fa-phone"
                            aria-hidden="true"
                        ></span>

                        Call (727) 755-3786

                    </a>


                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     CONTACT FORM
     ========================================================= -->

<section class="section-sm bg-gray-100 smart-contact-form-section">

    <div class="container">


        <h1>

            Get in

            <span class="font-weight-light">
                Touch
            </span>

        </h1>


        <!-- PROJECT DOCUMENT INFORMATION -->

        <div class="smart-contact-note">

            <div class="smart-contact-note-icon">
                📐
            </div>


            <div class="smart-contact-note-content">

                <h4>

                    Project Documents, Drawings or Estimate Information

                </h4>


                <p>

                    Our team will contact you within

                    <strong>
                        8 to 24 business hours
                    </strong>.

                    If you already have drawings, plans, photos, measurements, permits, inspection notes, or project documents, attach them below so we can review your project faster.

                </p>

            </div>

        </div>


        <!-- FORM RESULT MESSAGE -->

        <?php

        if (!empty($formMessage)) {

            echo $formMessage;

        }

        ?>


        <!-- =====================================================
             IMPORTANT:
             enctype="multipart/form-data"
             is required for file uploads.
             ===================================================== -->

        <form
            method="post"
            action="contacts.php"
            enctype="multipart/form-data"
        >


            <div class="form-row row-10 offset-xs">


                <!-- NAME -->

                <div class="col-lg-4">

                    <div class="form-group">

                        <label
                            class="rd-label rd-label-lg"
                            for="contact-name"
                        >
                            Name:
                        </label>

                        <input
                            class="form-control form-control-lg"
                            id="contact-name"
                            type="text"
                            name="name"
                            required
                        >

                    </div>

                </div>


                <!-- PHONE -->

                <div class="col-lg-4">

                    <div class="form-group">

                        <label
                            class="rd-label rd-label-lg"
                            for="contact-phone"
                        >
                            Phone:
                        </label>

                        <input
                            class="form-control form-control-lg"
                            id="contact-phone"
                            type="text"
                            name="phone"
                            required
                        >

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="col-lg-4">

                    <div class="form-group">

                        <label
                            class="rd-label rd-label-lg"
                            for="contact-email"
                        >
                            Email:
                        </label>

                        <input
                            class="form-control form-control-lg"
                            id="contact-email"
                            type="email"
                            name="email"
                            required
                        >

                    </div>

                </div>


                <!-- MESSAGE -->

                <div class="col-12">

                    <div class="form-group">

                        <label
                            class="rd-label rd-label-lg"
                            for="contact-message"
                        >
                            Message:
                        </label>

                        <textarea
                            class="form-control form-control-lg"
                            id="contact-message"
                            name="message"
                            required
                        ></textarea>

                    </div>

                </div>


                <!-- =================================================
                     PROJECT DOCUMENT UPLOAD
                     ================================================= -->

                <div class="col-12">

                    <div class="form-group smart-document-upload">


                        <label
                            class="smart-document-upload-title"
                            for="project-documents"
                        >

                            Upload Project Documents

                        </label>


                        <span class="smart-document-upload-description">

                            Attach drawings, plans, permits, inspection reports, photos, estimates, spreadsheets, CAD files, or other project documents. You may select multiple files.

                        </span>


                        <input
                            id="project-documents"
                            type="file"
                            name="project_documents[]"
                            multiple
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.txt,.dwg,.dxf"
                        >


                        <small>

                            Accepted file types: PDF, JPG, PNG, DOC, DOCX, XLS, XLSX, TXT, DWG and DXF. Maximum 10 MB per file and 20 MB total.

                        </small>


                    </div>

                </div>


            </div>


            <!-- GOOGLE RECAPTCHA -->

            <div
                class="g-recaptcha"
                data-sitekey="6Lc5AfsqAAAAADL-VFJrPdJ3KP1UARL1BOomvGN0"
            ></div>


            <!-- SUBMIT -->

            <div class="smart-contact-submit-wrap">

                <button
                    class="btn btn-primary smart-contact-submit"
                    type="submit"
                >

                    Submit

                </button>

            </div>


        </form>


        <script
            src="https://www.google.com/recaptcha/api.js"
            async
            defer
        ></script>


    </div>

</section>


<?php include 'sections-library/bottom-banner.html'; ?>

<?php include __DIR__ . '/sections-library/footer.php'; ?>


</body>

</html>
