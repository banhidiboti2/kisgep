export const fetchTermekek = async () => {
    const response = await fetch('/api/termekek');
    const data = await response.json();
    return data;
};

export const fetchKategoriak = async () => {
    const response = await fetch('/api/kategoriak');
    const data = await response.json();
    return data;
};