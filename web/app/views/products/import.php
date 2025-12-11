<style>
body { font-family:Arial; background:#f3f4f6; margin:0; padding:0; }
.center-wrapper { display:flex; justify-content:center; align-items:center; min-height:100vh; }
.card { width:380px; background:white; padding:32px; border-radius:12px; box-shadow:0 4px 14px rgba(0,0,0,0.1); }
h2 { text-align:center; }
input { width:100%; padding:12px; margin-top:12px; border-radius:6px; border:1px solid #ccc; }
.btn { width:100%; padding:12px; background:#222; color:white; border-radius:6px; margin-top:18px; text-align:center; display:block; }
.btn:hover { background:#444; }
.link { display:block; text-align:center; margin-top:12px; }
</style>

<div class="center-wrapper">
    <div class="card">
        <h2>Импорт CSV</h2>

        <form method="POST" action="/?route=products/uploadCsv" enctype="multipart/form-data">
            <input type="file" name="csv" required>
            <button class="btn">Импортировать</button>
        </form>

        <a class="link" href="/?route=products/index">Назад</a>
    </div>
</div>
