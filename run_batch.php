<?php
$batchFile = "C:\Users\Jerson\Downloads\biometrics\app.bat";

if (file_exists($batchFile)) {
    // Run the batch file in the background
    $output = shell_exec("start /B " . escapeshellarg($batchFile));
    echo "
        <script>
            alert('Application has been started!');
            window.location.href='index.php';
        </script>
    ";
} else {
    echo "
    <script>
            alert('Failed to start application!!');
            window.location.href='index.php';
        </script>
    ";
}
?>
