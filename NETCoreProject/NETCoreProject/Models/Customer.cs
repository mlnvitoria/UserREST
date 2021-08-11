using System;

namespace NETCoreProject.Models
{
    public class Customer : Entity
    {
        public string Name { get; set; }

        public DateTime Birthdate { get; set; }

        public bool Enabled { get; set; }
    }
}
