<?php
// 1. Sertakan file koneksi ke database
include "koneksi.php";

// 2. Query Data Alat dari Database
$query_alat = "SELECT * FROM data_alat ORDER BY id DESC";
$hasil_alat = mysqli_query($koneksi, $query_alat);
$data_alat  = mysqli_fetch_all($hasil_alat, MYSQLI_ASSOC);

// 3. Hitung Ringkasan Statistik
$total_jenis_alat = count($data_alat);
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Resmi & Inventaris Lab TKJ</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#f0f9ff',
              500: '#0ea5e9',
              600: '#0284c7',
            }
          }
        }
      }
    }
  </script>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-sans transition-colors duration-300">

  <!-- TOP NAVBAR -->
  <header class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
      
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-white font-black text-xl">
          <i class="fa-solid fa-network-wired"></i>
        </div>
        <div>
          <span class="font-extrabold text-lg text-slate-900 dark:text-white block leading-none">TKJ PORTAL</span>
          <span class="text-[10px] font-semibold text-cyan-600 dark:text-cyan-400 uppercase">Teknik Komputer & Jaringan</span>
        </div>
      </div>

      <div class="flex items-center space-x-3">
        <a href="tambah.php" class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-600 text-slate-900 font-bold text-xs shadow-md transition-all">
          <i class="fa-solid fa-plus mr-1.5"></i> Tambah Alat
        </a>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- DASHBOARD STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
      <div class="p-5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Total Jenis Alat</p>
          <p class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?php echo $total_jenis_alat; ?></p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-cyan-500/10 text-cyan-500 flex items-center justify-center text-xl">
          <i class="fa-solid fa-box-archive"></i>
        </div>
      </div>
    </div>

    <!-- TABLE DATA ALAT DARI DATABASE -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
      <div class="p-5 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
        <div>
          <h3 class="font-extrabold text-slate-900 dark:text-white text-base">🔌 Inventaris Data Alat Lab TKJ</h3>
          <p class="text-xs text-slate-500 dark:text-slate-400">Data terhubung langsung dengan database MySQL</p>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-50 dark:bg-slate-750 text-slate-500 dark:text-slate-400 font-bold uppercase border-b border-slate-200 dark:border-slate-700">
            <tr>
              <th class="px-5 py-3.5">ID</th>
              <th class="px-5 py-3.5">Nama Alat</th>
              <th class="px-5 py-3.5">Merk</th>
              <th class="px-5 py-3.5">Total Stok</th>
              <th class="px-5 py-3.5">Kondisi</th>
              <th class="px-5 py-3.5 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
            <?php if (!empty($data_alat)): ?>
              <?php foreach ($data_alat as $row): ?>
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-750/50">
                <td class="px-5 py-3.5 font-mono font-bold text-cyan-600 dark:text-cyan-400"><?php echo htmlspecialchars($row['id']); ?></td>
                <td class="px-5 py-3.5 font-bold text-slate-900 dark:text-white"><?php echo htmlspecialchars($row['nama_alat']); ?></td>
                <td class="px-5 py-3.5 text-slate-500"><?php echo htmlspecialchars($row['merk']); ?></td>
                <td class="px-5 py-3.5 font-mono font-bold"><?php echo htmlspecialchars($row['total_stok']); ?></td>
                <td class="px-5 py-3.5">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                    <?php echo htmlspecialchars($row['kondisi']); ?>
                  </span>
                </td>
                <td class="px-5 py-3.5 text-center space-x-1">
                  <a href="update.php?id=<?php echo $row['id']; ?>" class="px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-[11px] inline-block">
                    Update
                  </a>
                  <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="px-3 py-1.5 rounded-lg bg-red-500 hover:bg-red-600 text-white font-bold text-[11px] inline-block">
                    Delete
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="px-5 py-6 text-center text-slate-400">Belum ada data alat di database.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</body>
</html>