/** A user has many orders */
public function orders()
{
    return $this->hasMany(Order::class);
}