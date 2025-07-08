document.addEventListener("DOMContentLoaded", () => {
    const button = document.getElementById("generate-pdf");

    if (!button) return;

    button.addEventListener("click", () => {
        const content = document.getElementById("pdf-content");
        content.style.display = "block";
        if (!content) {
            alert("لم يتم العثور على عنصر المحتوى.");
            return;
        }

        // استخراج البيانات من الـ dataset
        const name = content.dataset.customer || "اسم غير متوفر";
        const date = content.dataset.date || "تاريخ غير متوفر";
        const number = content.dataset.number || "رقم غير متوفر";

        // وضع البيانات داخل عناصر HTML
        document.getElementById("customer-name").textContent = name;
        document.getElementById("report-date").textContent = date;
        document.getElementById("invoice-number").textContent = number;

        // إعدادات pdf
        const options = {
            margin: 0.5,
            filename: 'report.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // توليد PDF وحفظه
        html2pdf().set(options).from(content).save();
    });
});