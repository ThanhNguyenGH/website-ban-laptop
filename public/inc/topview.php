<div class="d-flex flex-column gap-3">
<?php foreach($laptop_noibat as $x): ?>
    <a href="index.php?action=chitiet&id=<?php echo $x['id']; ?>" 
       class="text-decoration-none text-dark d-flex align-items-center p-2 rounded hover-shadow bg-light">

        <img src="../<?php echo $x['hinhanh_ch'] ?? 'images/laptops/default.jpg'; ?>" 
             class="img-thumbnail me-3" 
             style="width:80px; height:80px; object-fit:cover;"
             alt="<?php echo htmlspecialchars($x['tenlaptop']); ?>">

        <div>
            <h6 class="mb-1 text-info"><?php echo htmlspecialchars($x['tenlaptop']); ?></h6>
            <p class="text-danger fw-bold mb-0"><?php echo number_format($x['giaban']); ?>đ</p>
        </div>
    </a>
<?php endforeach; ?>
</div>