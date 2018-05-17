export function PostData(type, userData) {
    let BaseURL = process.env.REACT_APP_DEV_API_URL;

    return new Promise((resolve, reject) => {
        fetch(BaseURL + type, {
            method: 'POST',
            body: JSON.stringify(userData),
        })
            .then((response) => response.json())
            .then((res) => {
                resolve(res);
            })
            .catch((error) => {
                reject(error);
            });
    });
}