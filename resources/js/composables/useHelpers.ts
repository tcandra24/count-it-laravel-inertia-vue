export function monthName(month: number): string {
    const months = ['', 'January', 'Febuary', 'March', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'October', 'November', 'December'];
    return months[month];
}

export function moneyFormat(amount: number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(amount);
}
