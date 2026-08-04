<?php
// ============================================================================
// SECURED BACKEND (PHP): Admin Editor with AES-256 Encryption
// ============================================================================

$configFile = 'config.json';
$passphrase = 'CompanySecret2026!'; // MASTER PASSPHRASE

// --- 1. AES-256 Encryption Helpers ---
function encryptAES256($plainText, $passphrase) {
    $salt = openssl_random_pseudo_bytes(8);
    $salted = '';
    $dx = '';
    while (strlen($salted) < 48) {
        $dx = md5($dx . $passphrase . $salt, true);
        $salted .= $dx;
    }
    $key = substr($salted, 0, 32);
    $iv  = substr($salted, 32, 16);
    $encrypted = openssl_encrypt($plainText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode("Salted__" . $salt . $encrypted);
}

function decryptAES256($cipherText, $passphrase) {
    $data = base64_decode($cipherText);
    if (strlen($data) < 16 || substr($data, 0, 8) !== "Salted__") return false;
    $salt = substr($data, 8, 8);
    $ct = substr($data, 16);
    $salted = '';
    $dx = '';
    while (strlen($salted) < 48) {
        $dx = md5($dx . $passphrase . $salt, true);
        $salted .= $dx;
    }
    $key = substr($salted, 0, 32);
    $iv  = substr($salted, 32, 16);
    return openssl_decrypt($ct, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

// Define the exact 32 Columns
$columns = [
    "CR ID", "Date Submitted", "Title / Summary", "Change Requestor", 
    "Dept / Team", "Description", "Change Category", "Risk Category", 
    "Change Priority", "Change Building Steps", "Planned Start Date", 
    "Planned End Date", "Vendor Support Required", "System Outage Required", 
    "Systems Affected", "Change Testing", "Change rollback", "CAB Approver", 
    "CAB Team Comments / Risk Assessed", "CAB Date", "Approval Status", 
    "Marketing Lead Approval", "IS Officer Approval", "Tester / QA", 
    "Target Implementation Date", "Actual Deployment Date", "Test Plan", 
    "Test Result", "Current Status", "Outcome", "Evidence Link(s)", "Notes"
];

// --- 2. Configuration & Path Logic ---
// Use __DIR__ to ensure config.json is always saved in the exact same folder as this PHP file
$configFile = __DIR__ . '/config.json';
$dataFile = '';

if (file_exists($configFile)) {
    $configData = json_decode(file_get_contents($configFile), true);
    if (is_array($configData) && isset($configData['data_file'])) {
        $dataFile = $configData['data_file'];
    }
}

// Write Data Helper (Wraps in JS)
function writeData($rows, $dataFile, $passphrase) {
    $memoryStream = fopen('php://temp', 'r+');
    foreach ($rows as $row) { fputcsv($memoryStream, $row); }
    rewind($memoryStream);
    $csvString = stream_get_contents($memoryStream);
    fclose($memoryStream);
    
    $encryptedData = encryptAES256($csvString, $passphrase);
    
    // Wrap the encrypted string in a JavaScript variable so HTML can load it natively
    $jsContent = "const ENCRYPTED_VAULT_DATA = `" . $encryptedData . "`;\n";
    
    // Use error suppression and return boolean so we can catch write errors
    $result = @file_put_contents($dataFile, $jsContent);
    return $result !== false;
}

$errorMsg = '';

// --- 3. HANDLE DATABASE SETUP POST LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_config') {
    
    // 1. Strip whitespace AND hidden double quotes (caused by Windows 11 "Copy as path")
    $rawPath = trim($_POST['file_path'] ?? '', " \t\n\r\0\x0B\"'");

    // 2. If path is empty, they clicked the "Change Path" reset button in the header
    if (empty($rawPath)) {
        if (file_exists($configFile)) { @unlink($configFile); }
        header("Location: " . basename($_SERVER['PHP_SELF']));
        exit;
    }

    // 3. Format Path to enforce .js and fix slashes
    $newPath = str_replace('\\', '/', $rawPath);
    
    // Auto-correct if the user pasted the old .enc file
    if (preg_match('/\.enc$/i', $newPath)) {
        $newPath = preg_replace('/\.enc$/i', '.js', $newPath);
    } elseif (!preg_match('/\.js$/i', $newPath)) {
        // If it's a folder, append the filename automatically
        $newPath = rtrim($newPath, '/') . '/register_data.js';
    }

    $isCreateNew = (isset($_POST['init_new']) && $_POST['init_new'] === '1');

    // 4. Logic for Create vs Connect
    if ($isCreateNew) {
        $dir = dirname($newPath);
        if (!is_dir($dir)) {
            $errorMsg = "The folder path does not exist. Please check the folder path:<br><code>" . htmlspecialchars($dir) . "</code>";
        } else {
            $initialRows = [
                ["Change Tracking Register — Sales & Marketing"],
                $columns,
                ["CR 00001", date('Y-m-d'), "Initial Setup Request", "Admin", "IT Ops", "Database initialized successfully.", "Minor", "Low", "Low", "Standard", date('Y-m-d'), date('Y-m-d'), "No", "No", "Change Register App", "Verified", "N/A", "System", "Auto-generated record.", date('Y-m-d'), "Approved", "N/A", "N/A", "System", date('Y-m-d'), date('Y-m-d'), "N/A", "Success", "Closed", "Success", "N/A", "Initialization record."]
            ];
            if (!writeData($initialRows, $newPath, $passphrase)) {
                $errorMsg = "Failed to create file. Your local web server (e.g. XAMPP) may not have Administrator permissions to write to this OneDrive folder:<br><code>" . htmlspecialchars($dir) . "</code>";
            }
        }
    } else {
        // Connecting to existing
        if (!file_exists($newPath)) {
            $errorMsg = "Could not find an existing file at:<br><code>" . htmlspecialchars($newPath) . "</code><br>Make sure the file exists, or click 'Create New File Here'.";
        }
    }

    // 5. Save Config and Redirect if no errors occurred
    if (empty($errorMsg)) {
        if (@file_put_contents($configFile, json_encode(['data_file' => $newPath])) === false) {
            $errorMsg = "Critical Error: Cannot write to local config.json. Please ensure this PHP file is in a folder where it has write permissions.";
        } else {
            header("Location: " . basename($_SERVER['PHP_SELF']));
            exit;
        }
    } else {
        // Retain the bad path in the input box so the user doesn't have to retype it
        $dataFile = $rawPath; 
    }
}

// --- 4. THE LOCATE UI INTERCEPT ---
// If the path is empty, file is missing, or we generated an error above, freeze and show setup
if (empty($dataFile) || !file_exists($dataFile) || !empty($errorMsg)) {
    // Generate an error if the config file points to a non-existent file and there isn't a custom error yet
    if (empty($errorMsg) && !empty($dataFile) && !file_exists($dataFile)) {
        $errorMsg = "Connection lost. File not found at:<br><code>" . htmlspecialchars($dataFile) . "</code>";
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Setup: Locate Database</title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; background: #f0f4f8; margin: 0;}
            .setup-card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 550px; border-top: 4px solid #4f46e5;}
            .setup-card h2 { margin-top: 0; color: #1e293b; display: flex; align-items: center; gap: 10px; font-size: 22px;}
            .setup-card p { color: #64748b; font-size: 14px; margin-bottom: 24px; line-height: 1.5; }
            .error-box { background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border: 1px solid #fca5a5; line-height: 1.5;}
            .error-box code { background: rgba(255,255,255,0.5); padding: 2px 6px; border-radius: 4px; display: block; margin-top: 6px; word-break: break-all; font-weight: 600;}
            label { display: block; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;}
            input[type="text"] { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: monospace; box-sizing: border-box; background: #f8fafc;}
            input[type="text"]:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px #ede9fe; background: white;}
            .btn-group { display: flex; gap: 12px; flex-direction: column; margin-top: 24px;}
            button { padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.2s; font-size: 14px;}
            .btn-connect { background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; }
            .btn-connect:hover { background: #e2e8f0; }
            .btn-create { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border: none; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); }
            .btn-create:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4); }
        </style>
    </head>
    <body>
        <div class="setup-card">
            <h2><span style="font-size: 28px;">📁</span> Locate Database</h2>
            <p>Please provide the absolute local path to your synced OneDrive folder. The system will automatically use the <strong>.js</strong> file format.</p>
            
            <?php if (!empty($errorMsg)): ?>
                <div class="error-box">
                    <strong>⚠️ Action Failed:</strong><br>
                    <?php echo $errorMsg; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="action" value="update_config">
                <div>
                    <label>Absolute File/Folder Path</label>
                    <input type="text" name="file_path" placeholder='C:\Users\Name\EVONSYS\...' 
                           value="<?php echo htmlspecialchars($dataFile); ?>" required>
                    <p style="font-size: 11px; color: #94a3b8; margin-top: 8px;">You can use Windows "Copy as path". We will format it automatically.</p>
                </div>
                
                <div class="btn-group">
                    <button type="submit" name="init_new" value="0" class="btn-connect">🔗 Connect to Existing File</button>
                    <button type="submit" name="init_new" value="1" class="btn-create">✨ Create New File Here</button>
                </div>
            </form>
        </div>
    </body>
    </html>
<?php
    exit; // Stop execution until the path is successfully set
}

// --- 5. MAIN APPLICATION LOGIC ---

// Read Data Function (Extracts data from JS wrapper)
function readData($dataFile, $passphrase) {
    if (!file_exists($dataFile)) return [];
    
    $fileContent = file_get_contents($dataFile);
    $encryptedData = '';
    
    // Extract the encrypted string from between the backticks
    if (preg_match('/`([^`]+)`/', $fileContent, $matches)) {
        $encryptedData = $matches[1];
    } else {
        $encryptedData = $fileContent; // Fallback
    }

    $csvString = decryptAES256($encryptedData, $passphrase);
    if ($csvString === false || trim($csvString) === '') return [];
    
    $memoryStream = fopen('php://temp', 'r+');
    fwrite($memoryStream, $csvString);
    rewind($memoryStream);
    $rows = [];
    while (($data = fgetcsv($memoryStream, 10000, ",")) !== FALSE) { $rows[] = $data; }
    fclose($memoryStream);
    return $rows;
}

// Process Add/Edit/Delete/Import Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] !== 'update_config') {
    $existingRows = readData($dataFile, $passphrase);

    if ($_POST['action'] === 'delete_row') {
        $crIdToDelete = $_POST['cr_id'];
        $newRows = [];
        foreach ($existingRows as $index => $row) {
            if ($index < 2 || (isset($row[0]) && $row[0] !== $crIdToDelete)) { $newRows[] = $row; }
        }
        writeData($newRows, $dataFile, $passphrase);
    } 
    elseif ($_POST['action'] === 'import_data') {
        $payload = json_decode($_POST['import_payload'], true);
        if (is_array($payload) && !empty($payload)) {
            // Find highest existing CR ID to auto-increment for missing ones
            $maxCrId = 0;
            foreach ($existingRows as $row) {
                if (isset($row[0]) && preg_match('/CR (\d+)/', $row[0], $matches)) {
                    $maxCrId = max($maxCrId, (int)$matches[1]);
                }
            }

            foreach ($payload as $importedRow) {
                $cleanRow = [];
                for ($i = 0; $i < count($columns); $i++) {
                    $val = isset($importedRow[$i]) ? $importedRow[$i] : '';
                    $cleanRow[] = htmlspecialchars(strip_tags((string)$val));
                }
                
                // Assign new CR ID if the imported row has it blank or invalid
                if (empty($cleanRow[0]) || !preg_match('/^CR \d+$/', $cleanRow[0])) {
                    $maxCrId++;
                    $cleanRow[0] = sprintf("CR %05d", $maxCrId);
                }
                
                $existingRows[] = $cleanRow;
            }
            writeData($existingRows, $dataFile, $passphrase);
        }
    }
    else {
        // Handle Add or Edit
        $newRow = [];
        foreach ($columns as $col) {
            $key = str_replace([' ', '/', '(', ')'], '_', $col);
            $newRow[] = isset($_POST[$key]) ? htmlspecialchars(strip_tags($_POST[$key])) : '';
        }

        if ($_POST['action'] === 'add_row') {
            $existingRows[] = $newRow;
        } 
        elseif ($_POST['action'] === 'edit_row') {
            $originalCrId = $_POST['original_cr_id'];
            foreach ($existingRows as $index => $row) {
                if ($index >= 2 && isset($row[0]) && $row[0] === $originalCrId) {
                    $existingRows[$index] = $newRow;
                }
            }
        }
        writeData($existingRows, $dataFile, $passphrase);
    }
    header("Location: " . basename($_SERVER['PHP_SELF']));
    exit;
}

// Prepare data for the UI
$allRows = readData($dataFile, $passphrase);
$tableData = (count($allRows) > 2) ? array_slice($allRows, 2) : [];
$tableData = array_reverse($tableData);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Register Admin Panel</title>
    <!-- Add SheetJS for Excel Export -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
    <style>
        /* Reusing your beautiful styling */
        :root {
            --bg-page: #f0f4f8; --bg-surface: #ffffff; --bg-card: #ffffff;
            --border-light: #e2e8f0; --border-med: #cbd5e1;
            --text-main: #1e293b; --text-muted: #64748b;
            --gradient-primary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --primary: #6d28d9; --primary-light: #ede9fe;
            --shadow-md: 0 8px 16px rgba(17, 12, 46, 0.08);
            --radius-md: 10px; --radius-lg: 16px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background-color: var(--bg-page); color: var(--text-main); line-height: 1.5; padding: 16px 24px; font-size: 13px; }

        /* Header */
        .app-header { background: var(--bg-surface); padding: 16px 24px; border-radius: var(--radius-lg); margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border-top: 4px solid var(--primary); }
        .app-header h1 { font-size: 18px; font-weight: 800; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .vault-notice { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #e0e7ff; color: #4338ca; border-radius: 20px; font-weight: 700; font-size: 11px; margin-top: 8px;}

        /* Buttons */
        .btn { padding: 10px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 8px; font-size: 13px;}
        .btn-submit { background: var(--gradient-primary); color: white; }
        .btn-clear { background-color: #f1f5f9; color: var(--text-main); border: 1px solid var(--border-med); }

        /* Drawer Overlay */
        .drawer-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 999; opacity: 0; pointer-events: none; transition: 0.3s; }
        .drawer-overlay.open { opacity: 1; pointer-events: auto; }
        .side-drawer { position: fixed; top: 0; right: -850px; width: 800px; max-width: 95vw; height: 100vh; background: var(--bg-page); z-index: 1000; box-shadow: -10px 0 40px rgba(0,0,0,0.15); transition: right 0.4s; display: flex; flex-direction: column; }
        .side-drawer.open { right: 0; }
        .drawer-header { background: var(--gradient-primary); color: white; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; }
        .close-drawer-btn { background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; }
        .drawer-content { padding: 24px; overflow-y: auto; flex-grow: 1; }

        /* Form Inputs */
        .input-group { margin-bottom: 12px; display: flex; flex-direction: column; }
        .input-group label { font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px; }
        .input-group input, .input-group select, .input-group textarea { padding: 7px 10px; border: 1px solid var(--border-med); border-radius: 6px; font-size: 12px; background-color: #f8fafc; }
        .input-group input[readonly] { background-color: var(--primary-light); color: var(--primary); font-weight: 700; border-style: dashed; }
        
        .columns-container { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .col-section { background: var(--bg-card); padding: 14px; border-radius: var(--radius-md); box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid var(--border-light); }
        .col-section h3 { font-size: 11px; margin: -14px -14px 12px -14px; padding: 8px 14px; border-radius: var(--radius-md) var(--radius-md) 0 0; color: white; background: #475569; }

        /* Table */
        .table-panel { background-color: var(--bg-surface); border: 1px solid var(--border-light); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); }
        .table-controls { padding: 16px 20px; border-bottom: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center; position: sticky; left: 0;}
        .filters { display: flex; gap: 12px; flex-grow: 1; justify-content: flex-end; }
        .filter-input, .filter-select { padding: 8px 14px; border: 1px solid var(--border-med); border-radius: 8px; font-size: 13px; }
        .table-scroll-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; white-space: nowrap; }
        th, td { padding: 14px 16px; border-bottom: 1px solid var(--border-light); text-align: left; }
        th { background-color: #f8fafc; position: sticky; top: 0; z-index: 20; font-size: 11px; text-transform: uppercase; cursor: pointer; border-bottom: 2px solid var(--border-light); }
        tbody tr:hover { background-color: #f1f5f9; }
        th:nth-child(1), td:nth-child(1) { position: sticky; left: 0; z-index: 15; background-color: var(--bg-surface); }
        th:nth-child(2), td:nth-child(2) { position: sticky; left: 100px; z-index: 15; background-color: var(--bg-surface); border-right: 1px solid var(--border-light); }
        th:nth-child(1), th:nth-child(2) { z-index: 25; background-color: #f8fafc; }
        
        /* Pagination */
        .pagination-controls { display: flex; justify-content: flex-end; align-items: center; gap: 15px; padding: 12px 20px; border-top: 1px solid var(--border-light); }
        .page-btn { background: #f1f5f9; border: 1px solid var(--border-med); border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; }
        .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #b45309; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }
        .action-btns { display: flex; gap: 8px; }
        .action-btn { background: white; border: 1px solid var(--border-med); border-radius: 6px; cursor: pointer; padding: 6px 10px; }
        
        /* Modal for Export */
        .export-modal { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.95); background: var(--bg-surface); padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); z-index: 1005; width: 400px; display: none; flex-direction: column; gap: 16px; opacity: 0; transition: 0.3s; }
        .export-modal.open { display: flex; opacity: 1; transform: translate(-50%, -50%) scale(1); }
    </style>
</head>
<body>

<div class="app-header">
    <div>
        <h1>Change Register Admin Panel</h1>
        <div class="vault-notice" title="<?php echo htmlspecialchars($dataFile); ?>">📁 Saving directly to .js</div>
    </div>
    <div style="display: flex; gap: 12px;">
        <!-- Re-trigger the setup screen to allow easy changing of path -->
        <form method="POST" style="margin: 0;">
            <input type="hidden" name="action" value="update_config">
            <input type="hidden" name="file_path" value=""> <!-- Clears path -->
            <button type="submit" class="btn btn-clear" style="font-size: 11px; padding: 6px 12px;">⚙️ Change Path</button>
        </form>
        
        <!-- Hidden Import Form & Input -->
        <form id="importForm" method="POST" style="display:none;">
            <input type="hidden" name="action" value="import_data">
            <input type="hidden" name="import_payload" id="importPayload">
        </form>
        <input type="file" id="importFile" accept=".xlsx, .xls, .csv" style="display: none;" onchange="handleImport(event)">
        
        <button class="btn btn-clear" onclick="document.getElementById('importFile').click()" style="border: 1px solid #3b82f6; color: #1d4ed8; background: #eff6ff;">📤 Import Excel</button>
        <button class="btn btn-clear" onclick="openExportModal()" style="border: 1px solid #10b981; color: #166534; background: #dcfce7;">⬇️ Export Excel</button>
        <button class="btn btn-submit" onclick="resetFormToAdd()">➕ Log New Change</button>
    </div>
</div>

<!-- Export Modal -->
<div class="export-modal" id="exportModal">
    <h2>⬇️ Export as Excel</h2>
    <div class="input-group"><label>Date (From)</label><input type="date" id="export_date_from"></div>
    <div class="input-group"><label>Date (To)</label><input type="date" id="export_date_to"></div>
    <div class="input-group">
        <label>Status</label>
        <select id="export_status">
            <option value="all">All Statuses</option>
            <option value="Submitted">Submitted</option>
            <option value="Approved">Approved</option>
            <option value="Closed">Closed</option>
            <option value="Rejected">Rejected</option>
        </select>
    </div>
    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
        <button class="btn btn-clear" onclick="closeExportModal()">Cancel</button>
        <button class="btn btn-submit" onclick="processExport()" style="background: #10b981;">Export Data</button>
    </div>
</div>

<!-- Slide-over Drawer -->
<div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
<div class="side-drawer" id="sideDrawer">
    <div class="drawer-header">
        <h2 id="form_title_text">✨ Log New Change</h2>
        <button type="button" class="close-drawer-btn" onclick="closeDrawer()">✖</button>
    </div>
    
    <div class="drawer-content">
        <form method="POST" action="" id="crForm">
            <input type="hidden" name="action" id="form_action" value="add_row">
            <input type="hidden" name="original_cr_id" id="original_cr_id" value="">
            
            <div class="columns-container">
                <div class="col-section">
                    <h3>📋 Core Info</h3>
                    <div style="display: flex; gap: 10px;">
                        <div class="input-group" style="flex: 1;"><label>CR ID (Locked)</label><input type="text" id="cr_id_input" name="CR_ID" readonly></div>
                        <div class="input-group" style="flex: 1;"><label>Date</label><input type="date" id="date_input" name="Date_Submitted" required></div>
                    </div>
                    <div class="input-group"><label>Title</label><input type="text" name="Title___Summary" required></div>
                    <div class="input-group"><label>Requestor</label><input type="text" name="Change_Requestor"></div>
                    <div class="input-group"><label>Dept</label><input type="text" name="Dept___Team"></div>
                </div>

                <div class="col-section">
                    <h3>🏷️ Classification</h3>
                    <div style="display: flex; gap: 10px;">
                        <div class="input-group" style="flex: 1;"><label>Category</label>
                            <select name="Change_Category"><option value="">Select...</option><option value="Major">Major</option><option value="Minor">Minor</option></select>
                        </div>
                        <div class="input-group" style="flex: 1;"><label>Risk</label>
                            <select name="Risk_Category"><option value="">Select...</option><option value="Low">Low</option><option value="High">High</option></select>
                        </div>
                    </div>
                    <div class="input-group"><label>Priority</label>
                        <select name="Change_Priority"><option value="">Select...</option><option value="Low">Low</option><option value="High">High</option></select>
                    </div>
                    <div class="input-group"><label>Systems Affected</label><input type="text" name="Systems_Affected"></div>
                </div>

                <div class="col-section">
                    <h3>📅 Schedule</h3>
                    <div style="display: flex; gap: 10px;">
                        <div class="input-group" style="flex: 1;"><label>Plan Start</label><input type="date" name="Planned_Start_Date"></div>
                        <div class="input-group" style="flex: 1;"><label>Plan End</label><input type="date" name="Planned_End_Date"></div>
                    </div>
                    <div class="input-group"><label>Target Impl.</label><input type="date" name="Target_Implementation_Date"></div>
                    <div class="input-group"><label>Actual Deploy</label><input type="date" name="Actual_Deployment_Date"></div>
                </div>

                <div class="col-section">
                    <h3>🏁 Status</h3>
                    <div class="input-group"><label>Approval Status</label>
                        <select name="Approval_Status"><option value="Pending">Pending</option><option value="Approved">Approved</option></select>
                    </div>
                    <div class="input-group"><label>Current Status</label>
                        <select name="Current_Status">
                            <option value="Submitted">Submitted</option><option value="Approved">Approved</option>
                            <option value="Closed">Closed</option><option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="input-group"><label>Outcome</label>
                        <select name="Outcome"><option value="">Select...</option><option value="Success">Success</option><option value="Failed">Failed</option></select>
                    </div>
                </div>
            </div>

            <div class="col-section" style="margin-bottom: 20px;">
                <div class="input-group"><label>Description</label><textarea name="Description" rows="2"></textarea></div>
                <div class="input-group"><label>Notes</label><input type="text" name="Notes"></div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="btn btn-clear" onclick="closeDrawer()">Cancel</button>
                <button type="submit" class="btn btn-submit" id="submit_btn">Save Record</button>
            </div>
        </form>
    </div>
</div>

<div class="table-panel">
    <div class="table-controls">
        <div style="display: flex; align-items: center; gap: 15px;">
            <span style="font-weight: 700; color: var(--text-muted);">Master Log (<span id="visible_count">0</span>)</span>
            <select id="pageSize" class="filter-select" onchange="changePageSize()" style="padding: 4px 8px; width: auto;">
                <option value="10">10 per page</option>
                <option value="50" selected>50 per page</option>
                <option value="100">100 per page</option>
                <option value="all">View All</option>
            </select>
        </div>
        <div class="filters">
            <input type="text" id="searchInput" class="filter-input" placeholder="🔍 Search..." onkeyup="filterTable()">
        </div>
    </div>

    <div class="table-scroll-wrapper">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>Action</th>
                    <?php foreach ($columns as $index => $col): ?>
                        <th onclick="sortTable(<?php echo $index + 1; ?>)"><?php echo htmlspecialchars($col); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>
    <div class="pagination-controls">
        <button onclick="prevPage()" id="btnPrev" class="page-btn">◀ Prev</button>
        <span id="pageInfo" style="font-weight: 600; font-size: 12px; color: var(--text-muted);">Page 1</span>
        <button onclick="nextPage()" id="btnNext" class="page-btn">Next ▶</button>
    </div>
</div>

<script>
    const columnsArray = <?php echo json_encode($columns); ?>;
    const allTableData = <?php echo json_encode($tableData, JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    
    let filteredData = [...allTableData];
    let currentPage = 1;
    let rowsPerPage = 50;

    document.addEventListener("DOMContentLoaded", renderTable);

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        
        let start = (currentPage - 1) * rowsPerPage;
        let end = rowsPerPage === 'all' ? filteredData.length : start + parseInt(rowsPerPage);
        let pageData = filteredData.slice(start, end);
        
        if (filteredData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="33" style="text-align: center; padding: 20px;">No records found.</td></tr>`;
        } else {
            pageData.forEach(row => {
                const escapedRow = JSON.stringify(row).replace(/'/g, "&apos;").replace(/"/g, "&quot;");
                let rowHtml = `<tr>
                    <td class="action-btns">
                        <button type="button" class="action-btn btn-edit-row" onclick='triggerEdit(${escapedRow})'>✏️</button>
                        <form method="POST" action="" style="margin:0;" onsubmit="return confirm('Delete record?');">
                            <input type="hidden" name="action" value="delete_row">
                            <input type="hidden" name="cr_id" value="${escapeHtml(row[0])}">
                            <button type="submit" class="action-btn btn-del-row">🗑️</button>
                        </form>
                    </td>`;
                
                row.forEach((cell, index) => {
                    let cellContent = escapeHtml(cell);
                    if ([7, 8, 20, 28, 29].includes(index) && cellContent !== '') {
                        let bClass = getBadgeClass(cellContent);
                        if (bClass) cellContent = `<span class='badge ${bClass}'>${cellContent}</span>`;
                    }
                    rowHtml += `<td>${cellContent}</td>`;
                });
                tbody.innerHTML += rowHtml + `</tr>`;
            });
        }
        updatePaginationUI();
    }

    function escapeHtml(text) { return String(text).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m])); }

    function getBadgeClass(value) {
        const v = value.toLowerCase().trim();
        if (['approved', 'success', 'closed', 'low'].includes(v)) return 'badge-success';
        if (['rejected', 'failed', 'high'].includes(v)) return 'badge-danger';
        if (['pending', 'medium', 'awaiting cab'].includes(v)) return 'badge-warning';
        if (['submitted', 'minor'].includes(v)) return 'badge-info';
        return '';
    }

    function changePageSize() {
        rowsPerPage = document.getElementById('pageSize').value;
        currentPage = 1; renderTable();
    }
    function prevPage() { if (currentPage > 1) { currentPage--; renderTable(); } }
    function nextPage() {
        const maxPage = rowsPerPage === 'all' ? 1 : Math.ceil(filteredData.length / rowsPerPage);
        if (currentPage < maxPage) { currentPage++; renderTable(); }
    }
    function updatePaginationUI() {
        const maxPage = rowsPerPage === 'all' ? 1 : Math.ceil(filteredData.length / rowsPerPage);
        document.getElementById('pageInfo').innerText = `Page ${currentPage} of ${maxPage || 1}`;
        document.getElementById('btnPrev').disabled = currentPage === 1;
        document.getElementById('btnNext').disabled = currentPage === maxPage || maxPage === 0;
        document.getElementById('visible_count').innerText = filteredData.length;
    }

    function openDrawer() { document.getElementById('drawerOverlay').classList.add('open'); document.getElementById('sideDrawer').classList.add('open'); }
    function closeDrawer() { document.getElementById('drawerOverlay').classList.remove('open'); document.getElementById('sideDrawer').classList.remove('open'); }

    function resetFormToAdd() {
        document.getElementById('crForm').reset();
        document.getElementById('form_action').value = 'add_row';
        document.getElementById('original_cr_id').value = '';
        document.getElementById('date_input').value = new Date().toISOString().split('T')[0];
        
        let maxNumber = 0;
        allTableData.forEach(row => {
            const match = row[0].match(/CR (\d+)/);
            if (match && match[1]) maxNumber = Math.max(maxNumber, parseInt(match[1], 10));
        });
        document.getElementById('cr_id_input').value = `CR ${String(maxNumber + 1).padStart(5, '0')}`;
        openDrawer();
    }

    function triggerEdit(rowData) {
        document.getElementById('form_action').value = 'edit_row';
        document.getElementById('original_cr_id').value = rowData[0];
        columnsArray.forEach((col, index) => {
            const input = document.querySelector('[name="' + col.replace(/[\s\/\(\)]/g, '_') + '"]');
            if (input) input.value = rowData[index] || '';
        });
        openDrawer();
    }

    function filterTable() {
        let sIn = document.getElementById('searchInput').value.toLowerCase();
        filteredData = allTableData.filter(row => row.join(" ").toLowerCase().includes(sIn));
        currentPage = 1; renderTable();
    }

    function openExportModal() { document.getElementById('drawerOverlay').classList.add('open'); document.getElementById('exportModal').classList.add('open'); }
    function closeExportModal() { document.getElementById('drawerOverlay').classList.remove('open'); document.getElementById('exportModal').classList.remove('open'); }
    
    function processExport() {
        const wb = XLSX.utils.book_new();
        const wsData = [["Change Register"], columnsArray, ...filteredData];
        const ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, "Export");
        XLSX.writeFile(wb, `Export.xlsx`);
        closeExportModal();
    }

    // --- IMPORT LOGIC ---
    function handleImport(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                
                // Parse to Array of Arrays
                const json = XLSX.utils.sheet_to_json(worksheet, {header: 1}); 
                
                let importedRows = [];
                
                for (let i = 0; i < json.length; i++) {
                    let row = json[i];
                    if (!row || row.length === 0) continue;
                    
                    // Skip title or header rows from our own export format
                    if (row[0] === 'Change Register' || row[0] === 'CR ID' || String(row[0]).includes('Change Tracking')) {
                        continue; 
                    }

                    // Normalize row to exactly 32 columns
                    let cleanRow = [];
                    for(let c=0; c<32; c++) {
                        cleanRow.push(row[c] !== undefined && row[c] !== null ? String(row[c]) : "");
                    }
                    
                    // Only add if the row has actual content
                    if (cleanRow.join("").trim() !== "") {
                        importedRows.push(cleanRow);
                    }
                }

                if (importedRows.length === 0) {
                    alert("No valid data found to import.");
                    return;
                }

                if (confirm(`Found ${importedRows.length} valid rows. Do you want to append them to the encrypted master register?`)) {
                    document.body.style.cursor = 'wait';
                    document.getElementById('importPayload').value = JSON.stringify(importedRows);
                    document.getElementById('importForm').submit();
                }
            } catch (err) {
                console.error(err);
                alert("Error parsing the Excel file. Please ensure it is a valid .xlsx or .csv file.");
            }
            
            // Reset input so the same file can be selected again
            event.target.value = '';
        };
        reader.readAsArrayBuffer(file);
    }
</script>
</body>
</html>