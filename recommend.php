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
        function copyToClipboard(element) {
            var text = element.innerText;
            navigator.clipboard.writeText(text).then(function() {
                var tooltip = document.getElementById('tooltip');
                var rect = element.getBoundingClientRect();
                tooltip.style.display = 'block';
                tooltip.style.left = rect.left + 'px';
                tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
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
            $disk = $_POST["disk"];
            $bandwidth = $_POST["bandwidth"];
            $bandwidth_peak = $_POST["bandwidth_peak"];

            // Calculate recommendations and provide affiliate links
            // This is where you would add your logic to calculate the recommendations
            // and generate affiliate links based on the user's input.

            echo "<h2>Recommendations</h2>";
            echo "<p>Based on your input, here are our recommendations:</p>";
            echo "<ul>";
            echo "<li>Recommended Memory: ... GB</li>"; // Add your calculated value here
            echo "<li>Recommended Disk: ... GB</li>"; // Add your calculated value here
            echo "<li>Recommended CPU: ... Cores</li>"; // Add your calculated value here
            echo "<li>Recommended Bandwidth Egress: ... Mbps</li>"; // Add your calculated value here
            echo "</ul>";

            echo "<p>Here are some web hosting providers that we recommend:</p>";
            echo "<ul>";
            echo "<li><a href='your_affiliate_link_1' target='_blank'>Web Host 1</a></li>";
            echo "<li><a href='your_affiliate_link_2' target='_blank'>Web Host 2</a></li>";
            echo "<li><a href='your_affiliate_link_3' target='_blank'>Web Host 3</a></li>";
            echo "</ul>";

        } else {
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <h2>Server Resource Usage</h2>

                <p>This form calculator helps you determine your existing Linux server's resource usage by asking your questions and providing an example Linux SSH command line(s) you can click on the command line text to automatically copy the text and then paste into your SSH session to get the answer. Your existing Linux server must already have <code>sar</code> command installed from <code>sysstat</code> YUM/APT packages.</p>

                <div id="tooltip" class="tooltip">Text copied to clipboard</div>
                <div class="form-group">
                    <label for="cpu_load_avg">Average CPU Load (1 minute):</label>
                    <input type="number" step="any" id="cpu_load_avg" name="cpu_load_avg" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -q | awk '/Average/ {print $4}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu_load_avg_5">Average CPU Load (5 minutes):</label>
                    <input type="number" step="any" id="cpu_load_avg_5" name="cpu_load_avg_5" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -q | awk '/Average/ {print $5}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu_load_avg_15">Average CPU Load (15 minutes):</label>
                    <input type="number" step="any" id="cpu_load_avg_15" name="cpu_load_avg_15" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -q | awk '/Average/ {print $6}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu_load_peak_1">Peak CPU Load (1 minute):</label>
                    <input type="number" step="any" id="cpu_load_peak_1" name="cpu_load_peak_1" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -q | awk 'NR > 3 && !/Average/ && !/ldavg-1/ && !/runq-sz/ && !/^$/ {if ($5 > max) max = $5} END {print max}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu_load_peak_5">Peak CPU Load (5 minutes):</label>
                    <input type="number" step="any" id="cpu_load_peak_5" name="cpu_load_peak_5" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -q | awk 'NR > 3 && !/Average/ && !/ldavg-1/ && !/runq-sz/ && !/^$/ {if ($6 > max) max = $6} END {print max}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu_load_peak_15">Peak CPU Load (15 minutes):</label>
                    <input type="number" step="any" id="cpu_load_peak_15" name="cpu_load_peak_15" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -q | awk 'NR > 3 && !/Average/ && !/ldavg-1/ && !/runq-sz/ && !/^$/ {if ($7 > max) max = $7} END {print max}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu">Average CPU Usage (%):</label>
                    <input type="number" id="cpu" name="cpu" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -u | awk '/Average/ {print 100 - $8}'</pre>
                </div>

                <div class="form-group">
                    <label for="cpu_peak">Peak CPU Usage (%):</label>
                    <input type="number" id="cpu_peak" name="cpu_peak" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -u | awk '/all/ && !/Average/ {if (100 - $9 > max) max = 100 - $9} END {print max}'</pre>
                </div>

                <div class="form-group">
                    <label for="memory">Average Memory Usage (GB):</label>
                    <input type="number" id="memory" name="memory" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">sar -r 1 5 | awk '/Average/ {print $2 / 1024}'</pre>
                </div>

                <div class="form-group">
                    <label for="memory_peak">Peak Memory Usage (GB):</label>
                    <input type="number" id="memory_peak" name="memory_peak" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">grep -i "Committed_AS" /proc/meminfo | awk '{print $2 / 1024 / 1024 " GB"}'</pre>
                </div>

                <div class="form-group">
                    <label for="disk">Current Disk Usage (GB):</label>
                    <input type="number" id="disk" name="disk" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">df -h | grep ' /$' | awk '{print $3}'</pre>
                </div>

                <div class="form-group">
                    <label for="bandwidth">Average Bandwidth Egress (Mbps):</label>
                    <input type="number" id="bandwidth" name="bandwidth" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">
interface=$(ip -o link show | awk '$9 == "UP" {print $2}' | sed 's/:$//' | head -n 1)
sar -n DEV 1 5 | grep $interface | awk '{total += $5} END {print (total / NR) * 8 / 1000 " Mbps"}'</pre>
                </div>

                <div class="form-group">
                    <label for="bandwidth_peak">Peak Bandwidth Egress (Mbps):</label>
                    <input type="number" id="bandwidth_peak" name="bandwidth_peak" step="0.01" required>
                    <pre class="copyText" onclick="copyToClipboard(this)">
interface=$(ip -o link show | awk '$9 == "UP" {print $2}' | sed 's/:$//' | head -n 1)
sar -n DEV | awk -v iface="$interface" '$2 == iface && $5 + $6 > max {max = $5 + $6} END {print "Interface: " iface ", Peak Bandwidth: " max * 8 / 1000 " Mbps"}'</pre>
                </div>

                <button type="submit">Submit</button>
            </form>
        <?php
        }
        ?>
    </div>
</body>
</html>
