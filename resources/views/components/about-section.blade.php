{{-- กำหนดค่าเริ่มต้น (Default Props) สามารถส่งค่าเปลี่ยนจากภายนอกได้ --}}
@props([
    'title' => 'เกี่ยวกับเรา',
    'description' => 'บริษัทของเราเปิดกิจการยาวนานกว่า 10 ปี มีฐานการผลิตสายคล้องคออยู่ที่มณฑลกวางตุ้ง ประเทศจีน ควบคุมคุณภาพการผลิตด้วยมาตรฐานญี่ปุ่น เรามีโรงงานผลิตสายคล้องบัตรของเราเอง ลูกค้าสามารถกำหนดรายละเอียดและออกแบบสายได้อย่างอิสระ ด้วยโรงงานที่ได้รับมาตรฐาน เราสามารถผลิตสายคล้องบัตรที่มีคุณภาพออกมาได้อย่างต่อเนื่อง',
    'buildingImage' => asset('images/about-building.jpg'),
    'mobileBuildingImage' => asset('images/about-building-mobile.jpg'),
    'cards' => [
        [
            'icon' => asset('images/icons/icon-about-factory.png'),
            'title' => 'โรงงานในจีน',
            'subtitle' => 'ฐานการผลิตที่มณฑลกวางตุ้ง'
        ],
        [
            'icon' => asset('images/icons/icon-about-standard.png'),
            'title' => 'มาตรฐานญี่ปุ่น',
            'subtitle' => 'ควบคุมคุณภาพอย่างเข้มงวด'
        ],
        [
            'icon' => asset('images/icons/icon-about-team.png'),
            'title' => 'ประสบการณ์ 10+ ปี',
            'subtitle' => 'ความเชี่ยวชาญที่พิสูจน์แล้ว'
        ],
        [
            'icon' => asset('images/icons/icon-about-globe.png'),
            'title' => 'ออกแบบอิสระ',
            'subtitle' => 'กำหนดรายละเอียดได้ตามต้องการ'
        ],
    ]
])

<div class="about-us-container">
  <!-- แบนเนอร์ด้านบน -->
  <div class="banner-wrapper">
    <!-- Mobile Title Bar (แสดงเฉพาะบน Mobile) -->
    <div class="mobile-title-bar">
      {{ $title }}
    </div>

    <!-- 1. ภาพอาคาร (แยก Desktop และ Mobile) พร้อมภาพโปร่งแสงทรงตัดเฉียงซ้อนทับ -->
    <div class="building-img-wrapper">
      <img src="{{ $buildingImage }}" alt="Building Desktop" class="building-bg desktop-building">
      <img src="{{ $mobileBuildingImage }}" alt="Building Mobile" class="building-bg mobile-building">
      <img src="{{ asset('images/blue-slant-overlay.png') }}" alt="Slant Overlay Desktop" class="slant-overlay-img desktop-slant-overlay">
      <img src="{{ asset('images/blue-mobile-overlay.png') }}" alt="Slant Overlay Mobile" class="slant-overlay-img mobile-slant-overlay">
    </div>
    
    <!-- 2. แถบสีน้ำเงินฝั่งซ้าย (Desktop) -->
    <div class="blue-overlay"></div>
    
    <!-- 3. ข้อความหัวข้อและรายละเอียด -->
    <div class="text-content-wrapper">
      <div class="text-content">
        <h2 class="desktop-title">{{ $title }}</h2>
        <p>{{ $description }}</p>
      </div>
    </div>
  </div>

  <!-- การ์ด 4 กล่องด้านล่าง (แสดงเฉพาะบน Desktop) -->
  <div class="card-grid-wrapper">
    <div class="card-grid">
      @foreach ($cards as $card)
        <div class="card-item">
          <img src="{{ $card['icon'] }}" alt="{{ $card['title'] }}" class="icon-img">
          <h3>{{ $card['title'] }}</h3>
          <p>{{ $card['subtitle'] }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>
