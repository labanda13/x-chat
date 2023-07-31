export default error => {
  if (!error.response) {
    return [
      'Lỗi không xác định'
    ]
  }

  try {
    return Object.values(error.response.data.errors).flat();
  } catch (e) {
    return [
      'Lỗi máy chủ'
    ]
  }
}
