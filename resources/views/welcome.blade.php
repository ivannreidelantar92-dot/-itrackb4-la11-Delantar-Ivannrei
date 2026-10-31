<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Drive Mockup</title>
        <style>
            :root {
                --bg: #171b23;
                --bg-strong: #0d1117;
                --sidebar: #1a1d26;
                --panel: #171c25;
                --panel-alt: #202632;
                --chrome: #1d212b;
                --chrome-2: #232a34;
                --line: rgba(255,255,255,0.08);
                --soft-line: rgba(255,255,255,0.04);
                --muted: #9aa5b4;
                --text: #edf3f8;
                --blue: #5c88ff;
                --blue2: #7ea4ff;
                --green: #78d2a5;
                --orange: #f39a42;
                --gold: #d8b164;
                --danger: #ee5b52;
                --shadow: rgba(0,0,0,0.35);
            }

            * { box-sizing: border-box; }

            html, body {
                margin: 0;
                height: 100%;
                background:
                    radial-gradient(circle at top, rgba(95,93,170,0.22), transparent 40%),
                    linear-gradient(180deg, #0f1218 0%, #0d1119 100%);
                color: var(--text);
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
            }

            .drive-shell {
                position: relative;
                width: min(100%, 1460px);
                height: min(92vh, 880px);
                background: linear-gradient(180deg, rgba(24,28,36,.95), rgba(16,20,27,.96));
                border: 1px solid rgba(255,255,255,0.06);
                border-radius: 26px;
                box-shadow: 0 35px 80px rgba(0,0,0,0.45);
                overflow: hidden;
            }

            .browser-bar {
                height: 68px;
                background: rgba(20,24,32,0.98);
                border-bottom: 1px solid var(--line);
                display: flex;
                align-items: center;
                padding: 0 16px 0 14px;
                gap: 18px;
            }

            .browser-controls {
                display: flex;
                align-items: center;
                gap: 12px;
                min-width: 120px;
            }

            .window-btn {
                width: 12px; height: 12px; border-radius: 50%;
                background: #3b4653; box-shadow: inset 0 0 0 1px rgba(255,255,255,0.06);
            }

            .window-btn:nth-child(1) { background: #c95a4a; }
            .window-btn:nth-child(2) { background: #d9b04d; }
            .window-btn:nth-child(3) { background: #57b66d; }

            .tabs {
                display: flex;
                align-items: stretch;
                flex: 1;
                gap: 10px;
                min-width: 0;
            }

            .tab {
                display: flex;
                align-items: center;
                gap: 10px;
                min-width: 180px;
                max-width: 260px;
                padding: 10px 14px;
                border-radius: 12px 12px 0 0;
                background: rgba(255,255,255,0.02);
                border: 1px solid transparent;
                color: var(--muted);
                font-size: 12px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .tab.active {
                background: rgba(255,255,255,0.04);
                border-color: rgba(255,255,255,0.05);
                color: #dfe7f5;
            }

            .tab .dot {
                width: 11px; height: 11px; border-radius: 3px;
                background: linear-gradient(135deg, #76a8ff, #4e7dff);
                display: inline-block;
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.18);
            }

            .tab .dot.orange { background: linear-gradient(135deg, #d8b36d, #b77926); }
            .tab .dot.green { background: linear-gradient(135deg, #55c78f, #32a36a); }

            .browser-utility {
                display: flex; align-items: center; gap: 12px;
                color: var(--muted);
                font-size: 20px;
            }

            .toolbar {
                height: 72px;
                background: rgba(30,35,43,0.96);
                border-bottom: 1px solid var(--line);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 18px 0 20px;
            }

            .address-wrap {
                display: flex; align-items: center; gap: 12px;
                flex: 1;
                min-width: 0;
            }

            .nav-arrows {
                display: flex; align-items: center; gap: 8px;
                color: #dfe7f5; font-size: 18px; opacity: .8;
            }

            .address-bar {
                display: flex; align-items: center;
                height: 38px; min-width: 0; flex: 1;
                max-width: 760px;
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.05);
                border-radius: 18px;
                padding: 0 14px;
                color: #dbe5f3;
                font-size: 13px;
            }

            .address-bar .lock {
                width: 10px; height: 10px; border-radius: 3px; background: #8ea2bd; margin-right: 10px; opacity: .9;
            }

            .address-bar .url { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

            .toolbar-actions {
                display: flex; align-items: center; gap: 12px;
            }

            .top-btn {
                width: 36px; height: 36px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                background: rgba(255,255,255,0.03); color: #dfeaf7; border: 1px solid rgba(255,255,255,0.05);
            }

            .workspace {
                display: grid;
                grid-template-columns: 220px 1fr;
                height: calc(100% - 140px);
            }

            .sidebar {
                background: rgba(19,21,27,0.94);
                border-right: 1px solid var(--line);
                padding: 18px 14px 10px;
                display: flex; flex-direction: column;
            }

            .brand {
                display: flex; align-items: center; gap: 12px;
                padding: 6px 8px 14px;
                font-weight: 600;
                color: #edf4ff;
            }

            .brand-mark {
                width: 18px; height: 18px; border-radius: 5px; background: linear-gradient(180deg, #6c86ff, #3c66ff); box-shadow: inset 0 0 0 1px rgba(255,255,255,0.18);
            }

            .side-section {
                margin-top: 12px;
            }

            .side-link {
                display: flex; align-items: center; justify-content: space-between; gap: 10px;
                padding: 10px 10px; border-radius: 10px; color: #dbe4f2; font-size: 14px; margin-bottom: 3px;
            }

            .side-link.active {
                background: rgba(101,117,255,0.12); border: 1px solid rgba(114,127,255,0.18);
            }

            .side-link .left {
                display: flex; align-items: center; gap: 10px;
            }

            .icon {
                width: 12px; height: 12px; border-radius: 3px; background: rgba(255,255,255,0.13);
                display: inline-block; border: 1px solid rgba(255,255,255,0.12);
            }

            .icon.home { background: linear-gradient(180deg, #a3b1c7, #7d8ea7); }
            .icon.folder { background: linear-gradient(180deg, #d7b56a, #a77628); }
            .icon.drive { background: linear-gradient(180deg, #76d4ff, #4a9eff); }
            .icon.clock { background: linear-gradient(180deg, #8fb8ff, #5474e6); }
            .icon.star { background: linear-gradient(180deg, #f4d775, #d99e2b); }
            .icon.trash { background: linear-gradient(180deg, #d9e3f4, #8ea0b6); }

            .storage-box {
                margin-top: auto; padding: 8px 8px 0; border-top: 1px solid var(--line);
            }

            .storage-label { font-size: 12px; color: var(--muted); margin-bottom: 8px; }
            .storage-progress {
                width: 100%; height: 6px; border-radius: 999px; background: rgba(255,255,255,0.08); overflow: hidden;
            }
            .storage-progress span { display: block; height: 100%; width: 76%; background: linear-gradient(90deg, #79d4ff, #4d7bf7); }

            .main-panel {
                background: rgba(17,20,26,1);
                display: flex;
                flex-direction: column;
                min-width: 0;
            }

            .file-header {
                height: 62px; display: flex; align-items: center; justify-content: space-between; padding: 0 18px 0 18px; border-bottom: 1px solid var(--line);
            }

            .file-title {
                display: flex; align-items: center; gap: 10px; font-size: 14px; color: #edf4ff;
            }

            .file-title strong { font-weight: 700; }
            .file-title .file-ext { font-size: 12px; color: var(--muted); }

            .action-row {
                display: flex; align-items: center; gap: 12px;
            }

            .pill {
                border-radius: 16px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 8px 12px; color: #edf4ff; font-size: 12px;
            }

            .pill.primary {
                background: linear-gradient(180deg, rgba(84,124,255,0.35), rgba(63,88,255,0.16)); border-color: rgba(126,158,255,0.38);
            }

            .workspace-pane {
                display: grid; grid-template-columns: minmax(0, 1.7fr) 320px; height: calc(100% - 62px); min-height: 0;
            }

            .editor-area {
                position: relative; padding: 16px; background: rgba(22,27,35,0.82); border-right: 1px solid var(--line);
            }

            .editor-card {
                position: relative; height: 100%; border-radius: 18px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); background: rgba(12,15,20,0.94);
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.02);
            }

            .editor-topbar {
                height: 40px; background: rgba(255,255,255,0.02); border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; padding: 0 12px;
            }

            .editor-tabs { display: flex; align-items: center; gap: 14px; color: var(--muted); font-size: 11px; }
            .editor-tabs .current { color: #edf4ff; }
            .editor-controls { display: flex; gap: 8px; }
            .editor-controls span { display: block; width: 10px; height: 10px; border-radius: 50%; background: rgba(255,255,255,0.16); }

            .code-wrap {
                display: flex; height: calc(100% - 40px);
            }

            .line-numbers {
                width: 52px; padding: 18px 8px 18px 0; text-align: right; border-right: 1px solid rgba(255,255,255,0.04); color: #5c6677; font-family: Consolas, monospace; font-size: 12px; line-height: 1.65;
            }

            pre {
                margin: 0; flex: 1; padding: 18px 14px; overflow: auto; font-family: Consolas, "Courier New", monospace; font-size: 12px; line-height: 1.62; color: #dfeaf5;
            }

            .token-key { color: #8dc2ff; }
            .token-str { color: #8fcaa0; }
            .token-num { color: #f0c07b; }
            .token-func { color: #d5b0ff; }
            .token-cmt { color: #5f6d7d; }
            .token-var { color: #a4d9ff; }
            .token-attr { color: #f7d3a0; }
            .token-operator { color: #d7dce4; }

            .sidebar-list {
                background: rgba(12,15,21,0.66); border-left: 1px solid rgba(255,255,255,0.03); padding: 18px 12px 14px;
                display: flex; flex-direction: column; gap: 10px;
            }

            .list-head {
                display: flex; align-items: center; justify-content: space-between; color: var(--muted); font-size: 13px; margin-bottom: 6px;
            }

            .mini-file {
                display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 8px 8px; border-radius: 10px; color: #dfeaf7; font-size: 12px; border: 1px solid rgba(255,255,255,0.04); background: rgba(255,255,255,0.02);
            }

            .mini-file.active { background: rgba(122,146,255,0.08); border-color: rgba(122,146,255,0.18); }
            .mini-file .meta { color: var(--muted); }

            .taskbar {
                position: absolute; left: 0; right: 0; bottom: 0; height: 48px; background: rgba(18,22,29,0.98); border-top: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; padding: 0 18px; z-index: 3;
            }

            .taskbar .left, .taskbar .right { display: flex; align-items: center; gap: 12px; }
            .taskbar .app-icon { width: 18px; height: 18px; border-radius: 5px; background: linear-gradient(180deg, #9ec7ff, #416ddd); }
            .taskbar .app-icon.orange { background: linear-gradient(180deg, #ffcf7b, #ef9b39); }
            .taskbar .app-icon.green { background: linear-gradient(180deg, #65dcbc, #2e9d68); }
            .taskbar .app-icon.purple { background: linear-gradient(180deg, #cf9afc, #7d52df); }
            .taskbar .time { color: #edf4ff; font-weight: 600; font-size: 13px; }

            @media (max-width: 1100px) {
                .workspace { grid-template-columns: 180px 1fr; }
                .workspace-pane { grid-template-columns: 1fr; }
                .sidebar-list { display: none; }
            }

            @media (max-width: 760px) {
                body { padding: 8px; }
                .drive-shell { width: 100%; height: 100vh; border-radius: 0; }
                .browser-bar { gap: 8px; }
                .tabs { display: none; }
                .workspace { grid-template-columns: 1fr; }
                .sidebar { display: none; }
                .file-header { padding: 0 10px; }
                .action-row { gap: 6px; }
                .pill { padding: 8px 8px; }
            }
        </style>
    </head>
    <body>
        <div class="drive-shell">
            <div class="browser-bar">
                <div class="browser-controls">
                    <span class="window-btn"></span>
                    <span class="window-btn"></span>
                    <span class="window-btn"></span>
                </div>

                <div class="tabs">
                    <div class="tab">
                        <span class="dot orange"></span>
                        <span>Track | Student Performance P...</span>
                    </div>
                    <div class="tab active">
                        <span class="dot"></span>
                        <span>1.png</span>
                    </div>
                    <div class="tab">
                        <span class="dot green"></span>
                        <span>Miranda, Renan James Z...</span>
                    </div>
                </div>

                <div class="browser-utility">
                    <span>－</span>
                    <span>□</span>
                    <span>×</span>
                </div>
            </div>

            <div class="toolbar">
                <div class="address-wrap">
                    <div class="nav-arrows">
                        <span>←</span>
                        <span>→</span>
                    </div>

                    <div class="address-bar">
                        <span class="lock"></span>
                        <span class="url">drive.google.com/drive/folders/1xG5dwsxKIRxyWISQ_...</span>
                    </div>
                </div>

                <div class="toolbar-actions">
                    <div class="top-btn">☆</div>
                    <div class="top-btn">⋮</div>
                </div>
            </div>

            <div class="workspace">
                <aside class="sidebar">
                    <div class="brand">
                        <span class="brand-mark"></span>
                        <span>Drive</span>
                    </div>

                    <div class="side-section">
                        <div class="side-link"><span class="left"><span class="icon home"></span>Home</span></div>
                        <div class="side-link"><span class="left"><span class="icon folder"></span>Projects</span></div>
                        <div class="side-link active"><span class="left"><span class="icon drive"></span>My Drive</span><span>›</span></div>
                        <div class="side-link"><span class="left"><span class="icon folder"></span>Computers</span></div>
                        <div class="side-link"><span class="left"><span class="icon folder"></span>Shared with me</span></div>
                        <div class="side-link"><span class="left"><span class="icon clock"></span>Recent</span></div>
                        <div class="side-link"><span class="left"><span class="icon star"></span>Starred</span></div>
                        <div class="side-link"><span class="left"><span class="icon trash"></span>Trash</span></div>
                    </div>

                    <div class="storage-box">
                        <div class="storage-label">919.7 MB of 15 GB used</div>
                        <div class="storage-progress"><span></span></div>
                        <div style="margin-top: 16px; display: flex; justify-content: center;">
                            <button style="width: 100%; padding: 10px 14px; border-radius: 18px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.02); color: #edf4ff; font-weight: 600;">Get more storage</button>
                        </div>
                    </div>
                </aside>

                <main class="main-panel">
                    <div class="file-header">
                        <div class="file-title">
                            <span style="font-size: 18px; opacity: 0.75;">◁</span>
                            <span class="icon folder" style="width: 14px; height: 14px; margin-right: 4px; background: linear-gradient(180deg, #d7b56a, #d69f38);"></span>
                            <span><strong>1.png</strong> <span class="file-ext">File</span></span>
                        </div>

                        <div class="action-row">
                            <span class="pill">File</span>
                            <span class="pill">View</span>
                            <span class="pill">Insert</span>
                            <span class="pill">Tools</span>
                            <span class="pill">Help</span>
                            <span class="pill primary">Open with</span>
                            <span class="pill primary">Share</span>
                        </div>
                    </div>

                    <div class="workspace-pane">
                        <section class="editor-area">
                            <div class="editor-card">
                                <div class="editor-topbar">
                                    <div class="editor-tabs">
                                        <span class="current">1.png</span>
                                        <span>•</span>
                                        <span>code</span>
                                    </div>
                                    <div class="editor-controls">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="code-wrap">
                                    <div class="line-numbers">
                                        1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br>10<br>11<br>12<br>13<br>14<br>15<br>16<br>17<br>18<br>19<br>20<br>21<br>22<br>23<br>24<br>25<br>26<br>27<br>28<br>29<br>30<br>31<br>32<br>33<br>34<br>35<br>36<br>37<br>38<br>39<br>40<br>41<br>42<br>43<br>44<br>45
                                    </div>

                                    <pre><span class="token-cmt">// Pseudo-code inspired by a file viewer mockup</span>
<span class="token-key">const</span> <span class="token-var">student</span> = {
  <span class="token-attr">name</span>: <span class="token-str">"Miranda, Renan James Z."</span>,
  <span class="token-attr">grade</span>: <span class="token-num">97</span>,
  <span class="token-attr">performance</span>: <span class="token-str">"Excellent"</span>,
  <span class="token-attr">subjects</span>: [<span class="token-str">"Math"</span>, <span class="token-str">"Programming"</span>, <span class="token-str">"Science"</span>]
};

<span class="token-key">function</span> <span class="token-func">calculateAverage</span>(<span class="token-var">scores</span>) {
  <span class="token-key">return</span> scores.reduce((<span class="token-var">sum</span>, <span class="token-var">value</span>) =&gt; sum + value, <span class="token-num">0</span>) / scores.length;
}

<span class="token-var">const</span> <span class="token-var">report</span> = <span class="token-func">calculateAverage</span>([<span class="token-num">95</span>, <span class="token-num">98</span>, <span class="token-num">96</span>, <span class="token-num">100</span>]);

<span class="token-key">if</span> (<span class="token-var">report</span> &gt;= <span class="token-num">95</span>) {
  console.<span class="token-func">log</span>(<span class="token-str">"Student is on track."</span>);
}

<span class="token-key">const</span> <span class="token-var">summary</span> = {
  <span class="token-attr">status</span>: <span class="token-str">"Promoted"</span>,
  <span class="token-attr">notes</span>: <span class="token-str">"Consistently above target performance."</span>,
  <span class="token-attr">nextStep</span>: <span class="token-str">"Continue mentoring and enrichment activities."</span>
};

<span class="token-key">export default</span> <span class="token-var">summary</span>;</pre>
                                </div>
                            </div>
                        </section>

                        <aside class="sidebar-list">
                            <div class="list-head">
                                <span>Files</span>
                                <span>⋮</span>
                            </div>

                            <div class="mini-file active">
                                <span>1.png</span>
                                <span class="meta">199 KB</span>
                            </div>
                            <div class="mini-file">
                                <span>2.png</span>
                                <span class="meta">160 KB</span>
                            </div>
                            <div class="mini-file">
                                <span>results.zip</span>
                                <span class="meta">82 KB</span>
                            </div>
                            <div class="mini-file">
                                <span>database.sql</span>
                                <span class="meta">58 KB</span>
                            </div>
                            <div class="mini-file">
                                <span>report.pdf</span>
                                <span class="meta">49 KB</span>
                            </div>
                            <div class="mini-file">
                                <span>notes.txt</span>
                                <span class="meta">27 KB</span>
                            </div>
                        </aside>
                    </div>
                </main>
            </div>

            <div class="taskbar">
                <div class="left">
                    <span class="app-icon"></span>
                    <span class="app-icon orange"></span>
                    <span class="app-icon green"></span>
                    <span class="app-icon purple"></span>
                </div>
                <div class="right">
                    <span class="time">3:52 PM</span>
                </div>
            </div>
        </div>
    </body>
</html>
