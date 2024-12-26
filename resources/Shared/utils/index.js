export const transformHeaderName = (key) => {
    switch (key) {
        case 'from':
            return 'Откуда';
        case 'to':
            return 'Куда';
        case 'arrival_date':
            return 'Дата прибытия';
        case 'price':
            return 'Цена';
        default:
            return key;
    }
}
