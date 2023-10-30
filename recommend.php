<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Resource Usage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #0271e1;
            color: white;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        button:hover {
            background-color: #0271e1;
        }
        .copyText {
            background-color: black;
            color: white;
            padding: 10px;
            cursor: pointer;
            margin-top: 5px;
            margin-bottom: 20px;
            display: inline-block;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        pre {
            white-space: pre-wrap;       /* Since CSS 2.1 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
        }
        .tooltip {
            display: none;
            position: absolute;
            background-color: black;
            color: white;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
    <script>
        function copyToClipboard(element, event) {
            var text = element.innerText;
            navigator.clipboard.writeText(text).then(function() {
                var tooltip = document.getElementById('tooltip');
                tooltip.style.display = 'block';
                tooltip.style.left = (event.pageX + 10) + 'px';
                tooltip.style.top = (event.pageY - tooltip.offsetHeight - 10) + 'px';
                setTimeout(function() {
                    tooltip.style.display = 'none';
                }, 2000); // Hide tooltip after 2 seconds
            }).catch(function(err) {
                alert('Could not copy text: ', err);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cpu_threads = $_POST["cpu_threads"];
            $cpu_load_avg = $_POST["cpu_load_avg"];
            $cpu_load_avg_5 = $_POST["cpu_load_avg_5"];
            $cpu_load_avg_15 = $_POST["cpu_load_avg_15"];
            $cpu_load_peak_1 = $_POST["cpu_load_peak_1"];
            $cpu_load_peak_5 = $_POST["cpu_load_peak_5"];
            $cpu_load_peak_15 = $_POST["cpu_load_peak_15"];
            $cpu = $_POST["cpu"];
            $cpu_peak = $_POST["cpu_peak"];
            $memory = $_POST["memory"];
            $memory_peak = $_POST["memory_peak"];
            $backup_copies = $_POST["backup_copies"];
            $disk = $_POST["disk"];
            $bandwidth = $_POST["bandwidth"];
            $bandwidth_peak = $_POST["bandwidth_peak"];

            // Calculate CPU recommendations
            $peak_cpu_load = max($cpu_load_peak_1, $cpu_load_peak_5, $cpu_load_peak_15);
            $recommended_cpus = $peak_cpu_load * $cpu_threads;
            $recommended_cpus = ceil($recommended_cpus); // Round up to the nearest integer

            // Calculate recommended memory (high range)
            $recommended_memory_low = ceil($memory / 2) * 2;
            $recommended_memory_high = ceil($memory_peak * 1.25);

            // Calculate Disk recommendations
            $recommended_disk_low = $disk;
            $recommended_disk_high = ($backup_copies + 1) * $disk;

            // Calculate Bandwidth recommendations
            $recommended_bandwidth_low = ($bandwidth * 60 * 60 * 24 * 30) / (8 * 1024 * 1024);
            $recommended_bandwidth_low = ceil($recommended_bandwidth_low); // Round up to the nearest integer
        
            $bandwidth_peak_tb_per_month = ($bandwidth_peak * 60 * 60 * 24 * 30) / (8 * 1024 * 1024);
            $recommended_bandwidth_high = ceil($bandwidth_peak_tb_per_month); // Round up to the nearest integer

            echo "<h2>Recommendations</h2>";
            echo "<p>Based on your input, here are our recommendations:</p>";
            echo "<ul>";
            echo "<li>Recommended CPU: $recommended_cpus Threads</li>";
            echo "<li>Recommended Memory: $recommended_memory_low - $recommended_memory_high GB</li>";
            echo "<li>Recommended Disk: $recommended_disk_low - $recommended_disk_high GB</li>";
            echo "<li>Recommended Bandwidth Egress: $recommended_bandwidth_low TB per month - $recommended_bandwidth_high TB per month</li>";
            echo "</ul>";

            echo "<p>Here are some web hosting providers that Centmin Mod recommends:</p>";
            echo "<ul>";
            echo "<li><a href='https://centminmod.com/hivelocity/' target='_blank'>Hivelocity.net</a></li>";
            echo "<li><a href='https://centminmod.com/clouvider' target='_blank'>Clouvider</a></li>";
            echo "<li><a href='https://centminmod.com/upcloud/' target='_blank'>Upcloud</a></li>";
            echo "<li><a href='https://centminmod.com/linode/' target='_blank'>Linode</a></li>";
            echo "<li><a href='https://centminmod.com/hetzner/' target='_blank'>Hetzner</a></li>";
            echo "<li><a href='https://centminmod.com/vultr/' target='_blank'>Vultr</a></li>";
            echo "<li><a href='https://centminmod.com/digitalocean/' target='_blank'>DigitalOcean</a></li>";
            echo "</ul>";

            echo "<p>Here are server tools that Centmin Mod recommends:</p>";
            echo "<ul>";
            echo "<li><a href='https://centminmod.com/hetrixtools/' target='_blank'>Hetrixtools - Uptime monitoring, Blacklist monitoring, and System metrics Agent etc</a></li>";
            echo "<li><a href='https://centminmod.com/backblaze' target='_blank'>Backblaze - personal backups, B2 S3 object storage</a></li>";
            echo "<li><a href='https://centminmod.com/dnsmadeeasy/' target='_blank'>DNSMadeEasy - DNS management</a></li>";
            echo "<li><a href='https://centminmod.com/nodeping/' target='_blank'>Nodeping - uptime monitoring</a></li>";
            echo "<li><a href='https://centminmod.com/statuscake/' target='_blank'>StatusCake - uptime monitoring</a></li>";
            echo "</ul>";

        } else {
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <h2>Server Resource Usage</h2>

                <p>This form calculator helps you determine your existing Linux server's resource usage by asking your questions and providing an example Linux SSH command line(s) you can click on the command line text to automatically copy the text and then paste into your SSH session to get the answer. Your existing Linux server must already have <code>sar</code> command installed from <code>sysstat</code> YUM/APT packages. The resource usage from <code>sar</code> command are only based on past 24hrs of activity and resource usage. You can pick a peak server/site activity time to run these commands.</p>

                <div class="form-group">
                    <label for="cpu_threads">Number of CPU Threads:</label>
                    <input type="number" id="cpu_threads" name="cpu_threads" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">nproc</pre>
                    <small>Use the above command in your server's terminal to find out the number of CPU threads.</small>
                </div>

                <div id="tooltip" class="tooltip">Text copied to clipboard</div>
                <div class="form-group">
                    <label for="cpu_load_avg">Average CPU Load (1 minute):</label>
                    <input type="number" step="any" id="cpu_load_avg" name="cpu_load_avg" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">awk -v nproc=$(nproc) '/Average/ {print $4 / nproc}' <(sar -q)</pre>
                </div>
                
                <div class="form-group">
                    <label for="cpu_load_avg_5">Average CPU Load (5 minutes):</label>
                    <input type="number" step="any" id="cpu_load_avg_5" name="cpu_load_avg_5" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">awk -v nproc=$(nproc) '/Average/ {print $5 / nproc}' <(sar -q)</pre>
                </div>
                
                <div class="form-group">
                    <label for="cpu_load_avg_15">Average CPU Load (15 minutes):</label>
                    <input type="number" step="any" id="cpu_load_avg_15" name="cpu_load_avg_15" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">awk -v nproc=$(nproc) '/Average/ {print $6 / nproc}' <(sar -q)</pre>
                </div>
                
                <div class="form-group">
                    <label for="cpu_load_peak_1">Peak CPU Load (1 minute):</label>
                    <input type="number" step="any" id="cpu_load_peak_1" name="cpu_load_peak_1" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">awk -v nproc=$(nproc) 'NR > 3 && !/Average/ && !/ldavg-1/ && !/runq-sz/ && !/^$/ {if ($5 > max) max = $5} END {print max / nproc}' <(sar -q)</pre>
                </div>
                
                <div class="form-group">
                    <label for="cpu_load_peak_5">Peak CPU Load (5 minutes):</label>
                    <input type="number" step="any" id="cpu_load_peak_5" name="cpu_load_peak_5" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">awk -v nproc=$(nproc) 'NR > 3 && !/Average/ && !/ldavg-1/ && !/runq-sz/ && !/^$/ {if ($6 > max) max = $6} END {print max / nproc}' <(sar -q)</pre>
                </div>
                
                <div class="form-group">
                    <label for="cpu_load_peak_15">Peak CPU Load (15 minutes):</label>
                    <input type="number" step="any" id="cpu_load_peak_15" name="cpu_load_peak_15" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">awk -v nproc=$(nproc) 'NR > 3 && !/Average/ && !/ldavg-1/ && !/runq-sz/ && !/^$/ {if ($7 > max) max = $7} END {print max / nproc}' <(sar -q)</pre>
                </div>

                <div class="form-group">
                    <label for="cpu">Average CPU Usage (%):</label>
                    <input type="number" id="cpu" name="cpu" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">sar -u | awk '/Average/ {print 100 - $8}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu_peak">Peak CPU Usage (%):</label>
                    <input type="number" id="cpu_peak" name="cpu_peak" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">sar -u | awk '/all/ && !/Average/ {if (100 - $9 > max) max = 100 - $9} END {print max}'</pre>
                </div>

                <div class="form-group">
                    <label for="memory">Average Memory Usage (GB):</label>
                    <input type="number" id="memory" name="memory" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">sar -r | awk '/Average/ {print $2 / 1024 / 1024}'</pre>
                </div>

                <div class="form-group">
                    <label for="memory_peak">Peak Memory Usage (GB):</label>
                    <input type="number" id="memory_peak" name="memory_peak" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">grep -i "Committed_AS" /proc/meminfo | awk '{print $2 / 1024 / 1024 " GB"}'</pre>
                </div>

                <div class="form-group">
                    <label for="backup_copies">Number of Local Backup Copies:</label>
                    <input type="number" id="backup_copies" name="backup_copies" required>
                    <small>Enter the number of local backup copies of your data that you want to keep at a time.</small>
                </div>

                <div class="form-group">
                    <label for="disk">Current Disk Usage (GB):</label>
                    <input type="number" id="disk" name="disk" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">df -h | grep ' /$' | awk '{print $3}'</pre>
                </div>

                <div class="form-group">
                    <label for="bandwidth">Average Bandwidth Egress (Mbps):</label>
                    <input type="number" id="bandwidth" name="bandwidth" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">
interface=$(ip -o link show | awk '$9 == "UP" {print $2}' | sed 's/:$//' | head -n 1)
sar -n DEV | grep $interface | grep -v Average | awk '{total += $5} END {print (total / NR) * 8 / 1000 " Mbps"}'</pre>
                </div>

                <div class="form-group">
                    <label for="bandwidth_peak">Peak Bandwidth Egress (Mbps):</label>
                    <input type="number" id="bandwidth_peak" name="bandwidth_peak" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this, event)">
interface=$(ip -o link show | awk '$9 == "UP" {print $2}' | sed 's/:$//' | head -n 1)
sar -n DEV | awk -v iface="$interface" '($3 == iface) && $1 !~ /^(Average:|IFACE)$/ && $1 ~ /^[0-9]/ {if ($5 > max) max = $5} END {print "Interface: " iface ", Peak Egress Bandwidth: " max * 8 / 1000 " Mbps"}'</pre>
                </div>

                <button type="submit">Submit</button>
            </form>
        <?php
        }
        ?>
    </div>
</body>
</html>
