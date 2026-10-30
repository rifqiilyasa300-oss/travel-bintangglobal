<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <div style="padding: 3rem 10%; background: #F9F7F2; min-height: 100vh; font-family: sans-serif;">
        <h2 style="color: #2C4E58; font-weight: 800; border-bottom: 3px solid #C5A367; display: inline-block; padding-bottom: 5px; margin-bottom: 2rem; text-transform: uppercase;">
            Kontak Kami
        </h2>

        <div style="display: flex; gap: 3rem; flex-wrap: wrap; align-items: flex-start;">

            <div style="flex: 2; min-width: 300px;">
                <div style="width: 100%; height: 350px; border-radius: 12px; overflow: hidden; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.9427845214044!2d106.8530467!3d-6.2712395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f2f2187317e1%3A0x6a05307c813f890c!2sJl.%20Raya%20Condet%20No.8a%2C%20RT.5%2FRW.3%2C%20Balekambang%2C%20Kec.%20Kramat%20jati%2C%20Kota%20Jakarta%20Timur!5e0!3m2!1sid!2sid!4v1713000000000"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

                <div style="line-height: 1.8; color: #333;">
                    <h4 style="color: #2C4E58; font-weight: 700; margin-bottom: 0.5rem; text-transform: uppercase;">KANTOR PUSAT :</h4>
                    <p style="margin-bottom: 1.5rem;">Jl. Raya Condet No.8a, RT.5/RW.3, Balekambang, Kec. Kramat jati, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13530</p>

                    <h4 style="color: #2C4E58; font-weight: 700; margin-bottom: 0.5rem; text-transform: uppercase;">Phone / Whatsapp :</h4>
                    <p style="margin-bottom: 1.5rem;">0858 5058 1030</p>

                    <h4 style="color: #2C4E58; font-weight: 700; margin-bottom: 0.5rem; text-transform: uppercase;">Alamat Email :</h4>
                    <p>admin@bintangglobal.co.id</p>
                </div>
            </div>

            <div style="flex: 1; min-width: 280px;">
                <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border-top: 4px solid #2C4E58;">
                    <h5 style="color: #2C4E58; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                        🔍 Cari Paket Impian Anda!
                    </h5>

                    <form action="{{ route('dashboard') }}" method="GET">
                        <select name="category" style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; color: #333; background-color: #fff;">
                            <option value="">Semua Kategori</option>
                            <option value="umroh_full">Paket Umroh</option>
                            <option value="hotel_only">Wholesale Hotel</option>
                            <option value="transport_only">Bus & Transport</option>
                        </select>


                        <button type="submit" style="width: 100%; background: #2C4E58; color: white; padding: 12px; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; transition: 0.3s; text-transform: uppercase;">
                            Cari Sekarang
                        </button>
                    </form>
                </div>


            </div>

        </div>
    </div>
</x-app-layout>
